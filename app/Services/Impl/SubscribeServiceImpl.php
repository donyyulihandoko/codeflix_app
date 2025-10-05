<?php

namespace App\Services\Impl;

use App\Models\Membership;
use App\Services\SubscribeService;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DateTime;

class SubscribeServiceImpl implements SubscribeService
{
    public function showPlans()
    {
        return  Plan::all();
    }

    public function checkoutPlan(Plan $plan)
    {
        return $plan;
    }

    public function savePlanInMembership(int $plan_id, bool $active, $start_date, $end_date): void
    {
        User::query()->find(Auth::user()->id)->memberships()->create([
            'plan_id' => $plan_id,
            'active' => $active,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }
}
