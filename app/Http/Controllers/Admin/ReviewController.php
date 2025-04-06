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

        // Add this line to fetch reviews for non-AJAX requests
        $reviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['success' => true]);
    }
}