<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends AdminController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::with(['user', 'product']);
            
            return DataTables::of($reviews)
                ->addColumn('action', function ($review) {
                    return view('admin.reviews.actions', compact('review'));
                })
                ->editColumn('rating', function ($review) {
                    return view('admin.reviews.rating', compact('review'));
                })
                ->editColumn('created_at', function ($review) {
                    return $review->created_at->format('M d, Y');
                })
                ->rawColumns(['action', 'rating'])
                ->make(true);
        }

        return view('admin.reviews.index');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['success' => true]);
    }
}