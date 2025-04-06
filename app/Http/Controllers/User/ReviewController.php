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
    public function completeOrder(Request $request, Order $order)
{
    // Check if the order is completed
    if ($order->status === 'completed') {
        // Generate receipt
        $receiptPath = $this->generateReceipt($order);

        // Send confirmation email with receipt
        Mail::to($order->user->email)->send(new OrderConfirmation($order, $receiptPath));

        return view('user.checkout.success', compact('order'))->with('receiptPath', $receiptPath);
    }

    return redirect()->route('orders.index')->with('error', 'Order is not completed yet.');
}

// Method to generate receipt
protected function generateReceipt(Order $order)
{
    $pdf = PDF::loadView('pdf.receipt', compact('order'));
    $path = 'receipts/' . $order->order_number . '.pdf';
    Storage::put('public/' . $path, $pdf->output());

    return 'storage/' . $path;
}

// Add a method for admin to mark orders as completed
public function markAsCompleted(Order $order)
{
    if (auth()->user()->isAdmin()) {
        $order->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
        
        // Generate receipt
        $receiptPath = $this->generateReceipt($order);
        
        // Send email notification to customer
        Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $receiptPath));
        
        return redirect()->back()->with('success', 'Order marked as completed and customer notified.');
    }
    
    return redirect()->back()->with('error', 'Unauthorized action.');
}
}