<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        return view('user.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()
            ->with(['brand', 'images'])
            ->paginate(12);
            
        return view('user.categories.show', compact('category', 'products'));
    }
}