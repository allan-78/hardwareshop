public function create(Request $request)
{
    $productId = $request->input('product');
    $product = Product::findOrFail($productId);
    
    // Check if user has purchased this product and order is completed
    $hasPurchased = Order::where('user_id', auth()->id())
        ->where('status', 'completed')
        ->whereHas('items', function($query) use ($productId) {
            $query->where('product_id', $productId);
        })
        ->exists();
    
    if (!$hasPurchased) {
        return redirect()->route('products.show', $product)
            ->with('error', 'You can only review products you have purchased and received.');
    }
    
    return view('user.reviews.create', compact('product'));
}