<?php

namespace App\Providers;

use App\Services\Impl\SubscribeServiceImpl;
use App\Services\SubscribeService;
use Illuminate\Support\ServiceProvider;

class SubscribeServiceProvider extends ServiceProvider
{

    public array $singletons = [
        SubscribeService::class => SubscribeServiceImpl::class
    ];

    public function provides()
    {
        return [
            SubscribeService::class
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
