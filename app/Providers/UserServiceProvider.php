<?php

namespace App\Providers;

use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public array $singletons = [
        UserService::class => UserServiceImpl::class
    ];

    public function provides()
    {
        return [
            UserService::class
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
