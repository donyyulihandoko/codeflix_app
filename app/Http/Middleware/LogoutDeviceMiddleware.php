<?php

namespace App\Http\Middleware;

use App\Services\DeviceLimitService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LogoutDeviceMiddleware
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
        if ($this->isLogOutRequest($request)) {
            $deviceId = Session::get('device_id');

            // panggil function dari service
            if ($deviceId) $this->deviceLimitService->logOutDevice($deviceId);
        }

        return $next($request);
    }

    private function isLogOutRequest(Request $request)
    {
        // periksa apakah route logout ini dari laravel fortify
        return $request->is('logout') || Route::currentRouteName('logout') === 'logout';
    }
}
