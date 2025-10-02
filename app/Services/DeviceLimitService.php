<?php

namespace App\Services;

use App\Models\User;

interface DeviceLimitService
{
    public function registerDevice(User $user);

    public function logoutDevice($deviceId);
}
