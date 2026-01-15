<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function show(Category $category)
    {
       
        $rooms = $this->categoryService->formattedRooms($category);

        return view('user.category', [
            'rooms' => $rooms,
            'category_name' => $category->name,
        ]);
    }
}
