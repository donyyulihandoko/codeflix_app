<?php

namespace App\Services\Impl;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Cache;

class CategoryServiceImpl implements CategoryService
{
    public function CategoryNav()
    {
        // $data = Cache::remember('nav_categories', 3600, function () {
        //     return Category::select('id', 'title', 'slug')
        //         ->orderBy('title', 'asc')
        //         ->get();
        // });

        $data = Category::all();
        return  $data->chunk(ceil($data->count() / 3));
    }

    public function getCategory(Category $category)
    {
        return $category;
    }

    public function showMovie(Category $category)
    {
        return $this->getCategory($category)->query()->movies()->latest()->get();
    }
}
