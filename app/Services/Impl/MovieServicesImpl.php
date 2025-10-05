<?php

namespace App\Services\Impl;

use App\Models\Movie;
use App\Services\MovieService;

class MovieServicesImpl implements MovieService
{
    public function latestMovie()
    {
        return Movie::query()->latest()->limit(8)->get();
    }

    public function popularMovie()
    {
        return Movie::query()->with('ratings')
            ->get()
            ->sortByDesc('average_rating')
            ->take(8);
    }
}
