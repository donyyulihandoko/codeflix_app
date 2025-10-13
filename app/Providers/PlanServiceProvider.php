<?php

namespace App\Providers;

use App\Services\Impl\PlanServiceImpl;
use App\Services\PlanService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider implements DeferrableProvider
{

    // public array $singletons = [
    //     PlanService::class => PlanServiceImpl::class
    // ];

    public function provides(): array
    {
        return [
            PlanService::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PlanService::class, function ($app) {
            return new PlanServiceImpl();
        });
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
