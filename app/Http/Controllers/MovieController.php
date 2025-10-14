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

    public function search(Request $request): Response
    {
        $search = $request->input('search');
        $movies = $this->movieService->search($search);

        return response()->view('movies.search', [
            'keyword' => $search,
            'movies' => $movies
        ]);
    }

    public function allMovie(): Response
    {
        $movies = $this->movieService->all();
        return response()->view('movies.all-movie', [
            'movies' => $movies
        ]);
    }

    public function all(Request $request)
    {
        $movies = $this->movieService->allMovie();
        if ($request->ajax()) {
            $html = view('components.movie-list', compact('movies'))->render();
            return response()->json([
                'html' => $html,
                'next_page' => $movies->nextPageUrl()  // Mengirim URL halaman berikutnya
            ]);
        }
        return view('movies.all', compact('movies'));
    }
}
