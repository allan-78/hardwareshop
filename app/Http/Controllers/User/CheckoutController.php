<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlaced; // Ensure this line is present
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $shipping = 50; // Default shipping fee
        $total = $subtotal + $shipping;

        return view('user.checkout.index', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function process(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        // Create order
        $order = $user->orders()->create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'subtotal' => $cartItems->sum(fn($item) => $item->price * $item->quantity),
            'shipping_fee' => 50, // Fixed shipping
            'total_amount' => $cartItems->sum(fn($item) => $item->price * $item->quantity) + 50,
            'status' => 'pending',
            'shipping_address' => $user->address,
            'shipping_city' => $user->city,
            'shipping_postal_code' => $user->postal_code,
            'shipping_phone' => $user->phone
        ]);
    
        // Add order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }
    
        // Clear cart
        $user->cartItems()->delete();
    
        // Send email notification
        Mail::to($user->email)->send(new OrderPlaced($order));

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        return view('user.checkout.success', compact('order'));
    }
}