<?php

namespace App\Providers;

use App\Services\DeviceLimitService;
use Illuminate\Support\ServiceProvider;
use App\Services\Impl\DeviceLimitServiceImpl;

class DeviceLimitServiceProvider extends ServiceProvider
{
    public array $singletons = [
        DeviceLimitService::class => DeviceLimitServiceImpl::class
    ];

    public function provides(): array
    {
        return [
            DeviceLimitService::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
