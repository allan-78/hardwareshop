<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function store(ReviewRequest $request, Product $product)
    {
        // Check if user has purchased the product
        $hasPurchased = auth()->user()->orders()
            ->whereHas('items', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        // Check if user has already reviewed
        $hasReviewed = $product->reviews()
            ->where('user_id', auth()->id())
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Review posted successfully');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->update($request->validated());
        return back()->with('success', 'Review updated successfully');
    }
}