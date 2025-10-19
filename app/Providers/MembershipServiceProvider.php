<?php

namespace App\Providers;

use App\Services\Impl\MembershipServiceImpl;
use Illuminate\Support\ServiceProvider;
use App\Services\MembershipService;

class MembershipServiceProvider extends ServiceProvider
{
    public array $singletons = [
        MembershipService::class => MembershipServiceImpl::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->singleton(MembershipService::class, function ($app) {
        //     return new MembershipServiceImpl();
        // });
    }

    public function provides(): array
    {
        return [
            MembershipService::class
        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
