<?php

namespace App\Services;

use App\Models\Plan;
use DateTime;

interface SubscribeService
{
    public function showPlans();

    public function checkoutPlan(Plan $plan);

    public function savePlanInMembership(int $plan_id, bool $active, $start_date, $end_date): void;
}
