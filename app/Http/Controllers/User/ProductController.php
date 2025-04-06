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
        $query = Product::query()->with(['category', 'brand']);

        // Advanced search with Scout (15pts)
        if ($request->filled('search')) {
            $products = Product::search($request->search)
                ->query(function ($builder) use ($request) {
                    return $this->applyFilters($builder, $request);
                })
                ->paginate(12)
                ->withQueryString();
        } else {
            $query = $this->applyFilters($query, $request);
            $products = $query->paginate(12)->withQueryString();
        }

        $categories = Category::all();
        $brands = Brand::all();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        return view('user.products.index', compact(
            'products',
            'categories',
            'brands',
            'minPrice',
            'maxPrice'
        ));
    }

    private function applyFilters($query, $request)
    {
        // Price filter (Quiz 2 - 10pts)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Category/Brand filter (Quiz 2 - additional 5pts)
        if ($request->filled('categories')) {
            $categories = is_array($request->categories) ? $request->categories : [$request->categories];
            $query->whereIn('category_id', $categories);
        }

        if ($request->filled('brands')) {
            $brands = is_array($request->brands) ? $request->brands : [$request->brands];
            $query->whereIn('brand_id', $brands);
        }

        // Sorting
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        return $query;
    }

    public function search(Request $request)
    {
        // Get the search query as a string
        $searchQuery = $request->input('query', '');
        
        if (empty($searchQuery)) {
            return redirect()->route('products.index')
                ->with('warning', 'Please enter a search term');
        }

        try {
            $products = Product::search($searchQuery)
                ->query(function ($builder) {
                    return $builder->with(['category', 'brand']);
                })
                ->paginate(12)
                ->withQueryString();

            $categories = Category::all();
            $brands = Brand::all();

            // Check if no results found
            if ($products->total() === 0) {
                return view('user.products.search', [
                    'products' => $products,
                    'searchQuery' => $searchQuery,
                    'categories' => $categories,
                    'brands' => $brands,
                    'noResults' => true,
                    'message' => "No products found matching '{$searchQuery}'"
                ]);
            }

            return view('user.products.search', [
                'products' => $products,
                'searchQuery' => $searchQuery,
                'categories' => $categories,
                'brands' => $brands
            ]);
        } catch (\Exception $e) {
            return redirect()->route('products.index')
                ->with('error', 'Search is temporarily unavailable');
        }
    }
}