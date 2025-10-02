<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Services\SubscribeService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SubscribeController extends Controller implements HasMiddleware

{
    private SubscribeService $subscribeService;
    private UserService $userService;

    public static function middleware()
    {
        return ['auth'];
    }

    public function __construct(SubscribeService $subscribeService, UserService $userService)
    {
        $this->subscribeService = $subscribeService;
        $this->userService = $userService;
    }

    public function showPlans(): Response
    {
        $plans = $this->subscribeService->showPlans();
        return response()->view('subscribe.plans', [
            'plans' => $plans
        ]);
    }

    public function checkoutPlan(Plan $plan): Response
    {
        $user = $this->userService->userLogin();
        $getDataPlan = $this->subscribeService->checkoutPlan($plan);
        return response()->view('subscribe.checkout', [
            'user' => $user,
            'plan' => $getDataPlan
        ]);
    }

    public function processCheckoutPlan(Request $request)
    {
        $plan = Plan::query()->findOrFail($request->plan_id);
        $this->subscribeService->savePlanInMembership(
            plan_id: $request->input('plan_id'),
            active: true,
            start_date: now(),
            end_date: now()->addDays($plan->duration)
        );
        return redirect()->route('subscribe.success');
    }

    public function checkoutSuccess(): Response
    {
        return response()->view('subscribe.success');
    }
}
