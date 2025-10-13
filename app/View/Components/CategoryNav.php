<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\CategoryService;

class CategoryNav extends Component
{
    public $categories;
    private CategoryService $categoryService;

    /**
     * Create a new component instance.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->categories = $this->categoryService->CategoryNav();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-nav');
    }
}
