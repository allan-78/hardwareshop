<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends AdminController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::withCount('products');
            
            return DataTables::of($brands)
                ->addColumn('action', function ($brand) {
                    return view('admin.brands.actions', compact('brand'));
                })
                ->editColumn('created_at', function ($brand) {
                    return $brand->created_at->format('M d, Y');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $brands = Brand::withCount('products')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        Brand::create($request->validated());
        
        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        
        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete brand with associated products'
            ], 422);
        }

        $brand->delete();
        return response()->json(['success' => true]);
    }
}