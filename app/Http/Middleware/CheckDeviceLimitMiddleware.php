<?php

namespace App\Http\Middleware;

use App\Models\UserDevice;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\DeviceLimitService;
use Illuminate\Support\Facades\Auth;

class CheckDeviceLimitMiddleware
{
    private DeviceLimitService $deviceLimitService;
    public function __construct(DeviceLimitService $deviceLimitService)
    {
        $this->deviceLimitService = $deviceLimitService;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // validasi apakah sudah login
        if (!$user) return $next($request);
        // 
        if ($request->routeIs('login') || $request->routeIs('register')) return $next($request);

        $sessionDeviceId = session('device_id');
        $getDevice = UserDevice::query()
            ->where('user_id', $user->id)
            ->where('device_id', $sessionDeviceId)
            ->first();

        if (!$getDevice) {
            $device = $this->deviceLimitService->registerDevice($user);

            if (!$device) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['device' => 'Anda telah mencapai batas maksimum device silahkan logout terlebih dahulu']);
            }
        }
        return $next($request);
    }
}
