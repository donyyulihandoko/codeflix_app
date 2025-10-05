<?php

namespace App\Http\Middleware;

use App\Services\DeviceLimitService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

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
        if ($this->logoutRequest($request)) {

            $deviceId = Session::get('device_id');

            if ($deviceId) {
                $this->deviceLimitService->logoutDevice($deviceId);
            }
        }

        return $next($request);
    }

    public function logoutRequest(Request $request)
    {
        // Periksa apakah request ini adalah logout dari Laravel Fortify
        return $request->is('logout') || Route::currentRouteName() === 'logout';
    }
}
