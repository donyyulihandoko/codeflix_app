<?php

namespace App\Services\Impl;

use App\Models\Movie;
use App\Models\User;
use App\Services\MovieService;
use BaconQrCode\Renderer\Path\Move;
use Illuminate\Support\Facades\Auth;

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

    public function detailMovie(Movie $movie)
    {
        return $movie;
    }

    public function getUrlMovie(string $urlResolution)
    {

        return Movie::query()->getUrlMovie($urlResolution);
    }

    public function search(string $search)
    {
        return Movie::query()->where('title', 'like', "%$search%")->get();
    }

    public function all()
    {
        return Movie::paginate(10);
    }

    public function allMovie()
    {
        return Movie::orderBy('release_date', 'desc')->paginate(10);
    }
}
