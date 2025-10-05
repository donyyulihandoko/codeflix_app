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
        // function untuk generate device info
        $deviceInfo = $this->getDeviceInfo();

        // function untuk mencari apaakah sudah ada device yang teregister
        $existingDevice = $this->findExistingDevice($user, $deviceInfo);

        if ($existingDevice) {
            $existingDevice->update(['last_active' => now()]);
            session(['device_id' => $existingDevice->device_id]);
            return $existingDevice;
        }

        // function untuk mengecek apakah user device sudah melewati batas max_devices
        if ($this->hasReachedDeviceLimit($user)) return false;

        // function untuk create user device baru
        $device = $this->createNewDevice($user, $deviceInfo);
        session(['device_id' => $device->device_id]);
        return $device;
    }


    public function logoutDevice($deviceId)
    {
        UserDevice::query()->where('device_id', $deviceId)->delete();
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
            'browser_version' => Agent::version(Agent::browser()),
        ];
    }

    private function generateDeviceName(): string
    {
        return ucfirst(Agent::platform() . ' ' . Agent::browser());
    }

    private function findExistingDevice($user, $deviceInfo)
    {
        UserDevice::query()->where('user_id', $user->id)
            ->where('device_name', $deviceInfo['device_name'])
            ->where('platform', $deviceInfo['platform'])
            ->where('browser', $deviceInfo['browser'])
            ->first();
    }

    private  function hasReachedDeviceLimit($user)
    {

        $maxDevices = $user->getCurrentPlan()->max_devices ?? 1;
        return UserDevice::where('user_id', $user->id)->count() >= $maxDevices;
        // $maxDevice = $user->getCurrentPlan()->max_devices ?? 1;
        // return  UserDevice::query()->where('user_id', $user->id)->count() >= $maxDevice;
    }

    private function createNewDevice(User $user, array $deviceInfo)
    {
        return UserDevice::create([
            'user_id' => $user->id,
            'device_name' => $deviceInfo['device_name'],
            'device_id' => uniqid(),
            'device_type' => $deviceInfo['device_type'],
            'platform' => $deviceInfo['platform'],
            'platform_version' => $deviceInfo['platform_version'],
            'browser' => $deviceInfo['browser'],
            'browser_version' => $deviceInfo['browser_version'],
            'last_active' => now(),
        ]);
    }
}
