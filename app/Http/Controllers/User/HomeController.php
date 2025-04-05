<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Featured products query
        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->where('featured', true)
            ->take(8)
            ->get();

        // Main products query with filters
        $query = Product::with(['category', 'brand', 'images'])
            ->when($request->search, function($q) use ($request) {
                return $q->where(function($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%")
                          ->orWhere('description', 'like', "%{$request->search}%");
                });
            })
            ->when($request->category, function($q) use ($request) {
                return $q->where('category_id', $request->category);
            })
            ->when($request->brand, function($q) use ($request) {
                return $q->where('brand_id', $request->brand);
            })
            ->when($request->min_price, function($q) use ($request) {
                return $q->where('price', '>=', $request->min_price);
            })
            ->when($request->max_price, function($q) use ($request) {
                return $q->where('price', '<=', $request->max_price);
            })
            ->when($request->sort, function($q) use ($request) {
                switch($request->sort) {
                    case 'price_asc':
                        return $q->orderBy('price', 'asc');
                    case 'price_desc':
                        return $q->orderBy('price', 'desc');
                    case 'newest':
                        return $q->latest();
                    default:
                        return $q->latest();
                }
            }, function($q) {
                return $q->latest();
            });

        // Execute queries
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        // Get price range for filters
        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        return view('user.home.index', compact(
            'products',
            'featuredProducts',
            'categories',
            'brands',
            'priceRange'
        ));
    }
}