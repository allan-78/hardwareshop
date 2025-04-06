@extends('user.layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 mb-6">Shopping Cart</h1>

        <div class="container">
            @if($cartItems->count() > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="bg-white rounded-lg shadow-sm mb-4">
                            <div class="p-4 border-bottom">
                                <h2 class="text-lg font-medium text-gray-900">Items ({{ $cartItems->count() }})</h2>
                            </div>
                            <div class="p-4">
                                @foreach($cartItems as $item)
                                    <div class="d-flex py-4 {{ !$loop->last ? 'border-bottom mb-3' : '' }}">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $item->product->primary_image_url }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="rounded shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>

                                        <div class="ms-4 flex-grow-1">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h3 class="font-medium">
                                                    <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none text-dark">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="font-medium">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                            </div>
                                            <p class="text-muted small mb-3">
                                                SKU: {{ $item->product->sku }}
                                            </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label for="quantity-{{ $item->id }}" class="me-2 text-muted small">Qty</label>
                                                    <select id="quantity-{{ $item->id }}" 
                                                            name="quantity" 
                                                            class="form-select form-select-sm" 
                                                            style="width: 80px;"
                                                            onchange="this.form.submit()">
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </form>
                                                
                                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm text-danger border-0">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="bg-white rounded-lg shadow-sm p-4 sticky-top" style="top: 20px;">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                            <div class="space-y-3">
                                <div class="d-flex justify-content-between py-2">
                                    <p class="text-muted">Subtotal</p>
                                    <p class="font-medium">₱{{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <p class="text-muted">Shipping</p>
                                    <p class="font-medium">₱{{ number_format($shipping, 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between py-3 border-top mt-3">
                                    <p class="font-medium">Total</p>
                                    <p class="font-medium">₱{{ number_format($total, 2) }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('checkout.index') }}" 
                                   class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-credit-card me-2"></i> Proceed to Checkout
                                </a>
                                <a href="{{ route('products.index') }}" 
                                   class="btn btn-outline-secondary w-100 mt-3">
                                    <i class="bi bi-arrow-left me-2"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 bg-white rounded-lg shadow-sm">
                    <div class="py-6">
                        <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                        <h3 class="text-lg font-medium text-gray-900 mt-4">Your cart is empty</h3>
                        <p class="mt-2 text-muted">Browse our products and add items to your cart.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection