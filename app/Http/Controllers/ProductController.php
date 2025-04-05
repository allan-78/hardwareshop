<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $products = Product::with(['brand'])
            ->when(request('categories'), function($query) {
                return $query->whereIn('category_id', request('categories'));
            })
            ->when(request('brands'), function($query) {
                return $query->whereIn('brand_id', request('brands'));
            })
            ->paginate(12);

        return view('user.products.index', compact('products', 'categories', 'brands'));
    }
}