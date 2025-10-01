<?php

namespace App\Services;

interface DeviceLimitService
{
    public function registerDevice();

    public function logoutDevice();
}
