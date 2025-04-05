<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $products = Product::with(['category', 'brand', 'images'])
            ->when($request->search, function($q) use ($request) {
                return $q->search($request->search);
            })
            ->when($request->categories, function($query) {
                return $query->whereIn('category_id', request('categories'));
            })
            ->when($request->brands, function($query) {
                return $query->whereIn('brand_id', request('brands'));
            })
            ->when($request->price_range, function($q) use ($request) {
                [$min, $max] = explode('-', $request->price_range);
                return $q->whereBetween('price', [$min, $max]);
            })
            ->paginate(12);

        if ($request->ajax()) {
            return view('user.products.list', compact('products'));
        }

        return view('user.products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'images', 'reviews' => function($query) {
            $query->with('user')->latest();
        }]);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}