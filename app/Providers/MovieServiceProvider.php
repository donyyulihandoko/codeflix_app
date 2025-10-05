<?php

namespace App\Providers;

use App\Services\Impl\MovieServicesImpl;
use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    public array $singletons = [
        MovieService::class => MovieServicesImpl::class
    ];

    public function provides(): array
    {
        return [
            MovieService::class
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
