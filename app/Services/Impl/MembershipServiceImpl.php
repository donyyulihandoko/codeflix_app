<?php

namespace App\Services\Impl;

use App\Services\MembershipService;
use App\Models\Membership;

class MembershipServiceImpl implements MembershipService
{
    public function membershipStatusCheck()
    {
        $checkStatus =  Membership::query()->where('active', true)
            ->where('end_date', '<', now()->toDateString())
            ->chunk(100, function ($memberships) {
                foreach ($memberships as $membership) {
                    $membership->update(['active' => false]);
                }
            });

        return $checkStatus;
    }
}
