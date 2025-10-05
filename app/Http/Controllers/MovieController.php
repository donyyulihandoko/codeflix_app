<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(): Response
    {
        return response()->view('movie.index', [
            'latestMovies' => $this->movieService->latestMovie(),
            'popularMovies' => $this->movieService->popularMovie()
        ]);
    }
}
