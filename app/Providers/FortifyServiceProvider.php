<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return response()->redirectTo(route('subscribe.plans'));
            }
        });

        // function login as membership
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {

                $user = User::query()->find(Auth::user()->id);
                if ($user->hasMembershipPlan()) {
                    return response()->redirectToIntended(config('fortify.home'));
                }

                return response()->redirectTo(route('subscribe.plans'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::registerView(function (): Response {
            return response()->view('auth.register');
        });

        Fortify::loginView(function (): Response {
            return response()->view('auth.login');
        });

        Fortify::requestPasswordResetLinkView(function (): Response {
            return response()->view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function (Request $request): Response {
            return response()->view('auth.reset-password', [
                'request' => $request
            ]);
        });
    }
}
