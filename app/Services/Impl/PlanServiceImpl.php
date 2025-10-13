<?php

namespace App\Services\Impl;

use App\Services\PlanService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PlanServiceImpl implements PlanService
{
    private function getCurrentPlan()
    {
        return User::query()->find(Auth::user()->id)->plans()->where('active', true)->first();
    }
    public function getPlanResolution()
    {
        return  $this->getCurrentPlan()->resolution;
    }
}
