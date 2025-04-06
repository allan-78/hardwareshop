// ... existing code ...

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