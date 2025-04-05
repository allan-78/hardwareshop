<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::with(['category', 'brand', 'images'])
                ->withTrashed();

            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    $buttons = '<div class="btn-group">';
                    if ($product->trashed()) {
                        $buttons .= '<button data-id="'.$product->id.'" class="btn btn-sm btn-success restore-btn">Restore</button>';
                    } else {
                        $buttons .= '<a href="'.route('admin.products.edit', $product).'" class="btn btn-sm btn-primary">Edit</a>';
                        $buttons .= '<button data-id="'.$product->id.'" class="btn btn-sm btn-danger delete-btn">Delete</button>';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->addColumn('image', function ($product) {
                    return '<img src="'.asset('storage/' . $product->first_image_url).'" height="50">';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.products.index');
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $key === 0
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('admin.products.index')
            ->with('success', 'Products imported successfully');
    }

    // Add other CRUD methods...
}