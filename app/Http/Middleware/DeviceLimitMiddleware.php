<?php

namespace App\Http\Middleware;

use App\Models\UserDevice;
use App\Services\DeviceLimitService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DeviceLimitMiddleware
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

        // validasi jika bukan user
        if (!$user) return $next($request);

        // validasi jika baru login/register
        if ($request->routeIs('login') || $request->routeIs('logout')) return $next($request);

        // validasi session device
        $sessionDeviceId = session('device_id');

        $getDevice = UserDevice::query()->where('user_id', $user->id)
            ->where('device_id', $sessionDeviceId)
            ->first();

        // jika device tidak ada maka masuk ke if untuk register device
        if (!$getDevice) {
            $registerDevice = $this->deviceLimitService->registerDevice($user);

            // jika registerDevice gagal

            if (!$registerDevice) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['device' => 'Anda telah mencapai batas maksimum perangkat. Silakan logout dari perangkat lain.']);
            }
        }

        // jika getdevice ada
        return $next($request);
    }
}
