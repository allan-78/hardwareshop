<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Add this import
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends AdminController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::withCount('products');
            
            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    return view('admin.categories.actions', compact('category'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Change from get() to paginate()
        $categories = Category::withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => true]);
    }
}