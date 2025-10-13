<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\MovieService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategoryController extends Controller implements HasMiddleware
{
    private UserService $userService;
    private MovieService $movieService;
    private CategoryService $categoryService;

    public function __construct(UserService $userService, MovieService $movieService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->movieService = $movieService;
        $this->categoryService = $categoryService;
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'device_limit'
        ];
    }

    public function show(Category $getCategory): Response
    {
        // $getCategory = $this->categoryService->getCategory($category);
        $movie = $getCategory->movies()->latest()->get();
        return response()->view('categories.show', [
            'category' => $getCategory,
            'movie' => $movie
        ]);
    }
}
