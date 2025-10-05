<?php

namespace App\Services\Impl;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Cache;

class CategoryServiceImpl implements CategoryService
{
    public function CategoryNav()
    {
        $data = Cache::remember('nav_categories', 3600, function () {
            return Category::query()->where('id', 'title', 'slug')
                ->orderBy('title', 'asc')
                ->get();
        });

        return  $data->chunk(ceil($data->count() / 3));
    }
}
