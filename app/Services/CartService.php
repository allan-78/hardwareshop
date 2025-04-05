<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCartItems()
    {
        return Cart::where('user_id', Auth::id())
            ->with('product.images')
            ->get();
    }

    public function getCartCount()
    {
        return Cart::where('user_id', Auth::id())->sum('quantity');
    }

    public function getTotal()
    {
        return Cart::where('user_id', Auth::id())
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total') ?? 0;
    }
}