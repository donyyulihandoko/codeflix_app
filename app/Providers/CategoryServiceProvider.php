<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\Impl\CategoryServiceImpl;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{

    public array $singletons = [
        CategoryService::class => CategoryServiceImpl::class
    ];

    public function provides(): array
    {
        return [
            CategoryService::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->singleton(CategoryService::class, function ($app) {
        //     return new CategoryServiceImpl();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
