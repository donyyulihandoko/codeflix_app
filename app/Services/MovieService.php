<?php

namespace App\Services;

use App\Models\Movie;

interface MovieService
{
    public function latestMovie();

    public function popularMovie();

    public function detailMovie(Movie $movie);

    public function getUrlMovie(string $urlResolution);
}
