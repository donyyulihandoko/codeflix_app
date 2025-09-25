<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Models\UserDevice;
use App\Services\DeviceLimitService;
use Jenssegers\Agent\Facades\Agent;

class DeviceLimitServiceImpl implements DeviceLimitService
{
    public function registerDevice(User $user)
    {
        $deviceInfo = $this->getDeviceInfo();

        $findExistingDevice = $this->findExistingDevice($user, $deviceInfo);

        // validasi apakah sudah ada device yang sudah login
        if ($findExistingDevice) {
            $findExistingDevice->update(['last_active' => now()]);
            session(['device_id' => $findExistingDevice->device_id]);
            return $findExistingDevice;
        }

        // validasi apakah user sudah melewati limit device
        if ($this->hasReachedLimitDevice($user)) {
            return false; //tidak bisa login dengan device baru
        }

        // create new device 
        $device = $this->createNewDevice($user, $deviceInfo);

        $getDeviceId = UserDevice::query()->where('user_id', $user->id);
        session(['device_id' => $getDeviceId->device_id]);

        return $device;
    }

    public function logOutDevice($deviceId)
    {
        UserDevice::query()->where('device_id', $deviceId);
        session()->forget('device_id');
    }


    private function getDeviceInfo(): array
    {
        return [
            'device_name' => $this->generateDeviceName(),
            'device_type' => Agent::isDesktop() ? 'desktop' : (Agent::isPhone() ? 'phone' : 'tablet'),
            'platform' => Agent::platform(),
            'platform_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser())
        ];
    }

    private function generateDeviceName(): string
    {
        return ucfirst(Agent::platform()) . ' ' . ucfirst(Agent::browser());
    }

    private function findExistingDevice(User $user, array $deviceInfo)
    {
        return UserDevice::query()->where('user_id', $user->id)
            ->where('device_type', $deviceInfo['device_type'])
            ->where('platform', $deviceInfo['platform'])
            ->where('browser', $deviceInfo['browser'])
            ->first();
    }
    // function untuk validasi limit device
    private function hasReachedLimitDevice(User $user)
    {
        $maxDevice = $user->getCurrentPlan()->maxDevice ?? 1;
        return UserDevice::query()->where('user_id', $user->id)->count() >= $maxDevice;
    }

    // function untuk create new device
    private function createNewDevice(User $user, array $deviceInfo)
    {
        UserDevice::query()->create([
            'user_id' => $user->id,
            'device_name' => $deviceInfo['device_name'],
            'device_id' => uniqid(),
            'device_type' => $deviceInfo['device_type'],
            'platform' => $deviceInfo['platform'],
            'platform_version' => $deviceInfo['platform_version'],
            'browser' => $deviceInfo['browser'],
            'browser_version' => $deviceInfo['browser_version'],
            'last_active' => now()
        ]);
    }
}
