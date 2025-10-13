<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieService;
use App\Services\PlanService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller implements HasMiddleware
{

    private UserService $userService;
    private PlanService $planService;
    private MovieService $movieService;

    public function __construct(MovieService $movieService, UserService $userService, PlanService $planService)
    {
        $this->userService = $userService;
        $this->planService = $planService;
        $this->movieService = $movieService;
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'device_limit'
        ];
    }

    public function index(): Response
    {
        $latestMovies = $this->movieService->latestMovie();
        $popularMovies = $this->movieService->popularMovie();

        return response()->view('movies.index', [
            'latestMovies' => $latestMovies,
            'popularMovies' => $popularMovies
        ]);
    }

    public function detailMovie(Movie $movie): Response
    {
        $detailMovie = $this->movieService->detailMovie($movie);
        $resolutionPlan = $this->planService->getPlanResolution();

        return response()->view('movies.show', [
            'movie' => $detailMovie,
            'streamingUrl' => $detailMovie->getUrlMovie($resolutionPlan)
        ]);
    }
}
