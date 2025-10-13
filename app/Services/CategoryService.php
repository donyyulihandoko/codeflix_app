<?php

namespace App\Services;

use App\Models\Category;

interface CategoryService
{
    public function CategoryNav();

    public function getCategory(Category $category);

    public function showMovie();
}
