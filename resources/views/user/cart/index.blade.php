@extends('user.layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Shopping Cart</h1>

        <div class="container py-8">
            @if($cartItems->count() > 0)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-4 py-6 sm:px-6">
                        <h2 class="text-lg font-medium text-gray-900">Shopping Cart</h2>
                        <div class="mt-6">
                            @foreach($cartItems as $item)
                                <div class="flex py-6 border-b border-gray-200">
                                    <!-- Cart item content -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->product->primary_image_url }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-24 h-24 object-cover rounded-md">
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a href="{{ route('products.show', $item->product) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="ml-4">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">
                                                SKU: {{ $item->product->sku }}
                                            </p>
                                        </div>

                                        <div class="flex-1 flex items-end justify-between text-sm">
                                            <div class="flex items-center">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label for="quantity-{{ $item->id }}" class="mr-2 text-gray-500">Qty</label>
                                                    <select id="quantity-{{ $item->id }}" 
                                                            name="quantity" 
                                                            onchange="this.form.submit()"
                                                            class="rounded-md border-gray-300 py-1.5 text-base leading-8 text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                                                        @for($i = 1; $i <= min(10, $item->product->stock); $i++)
                                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </div>

                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="font-medium text-red-600 hover:text-red-500">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty cart message -->
            @endif
        </div>

        <!-- Clear Cart -->
        <div class="mt-6">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="text-sm font-medium text-gray-600 hover:text-gray-500">
                    Clear Cart
                </button>
            </form>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="mt-16 lg:mt-0 lg:col-span-4">
        <div class="bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8">
            <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Subtotal</p>
                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($subtotal, 2) }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Shipping</p>
                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($shipping, 2) }}</p>
                </div>
                <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                    <p class="text-base font-medium text-gray-900">Order Total</p>
                    <p class="text-base font-medium text-gray-900">₱{{ number_format($total, 2) }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('checkout.index') }}" 
                   class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>

        <!-- Continue Shopping -->
        <div class="mt-6 text-center">
            <a href="{{ route('products.index') }}" 
               class="text-sm font-medium text-blue-600 hover:text-blue-500">
                Continue Shopping<span aria-hidden="true"> &rarr;</span>
            </a>
        </div>
    </div>
</div>

<!-- Remove the JavaScript since we're using form submission -->
@push('scripts')
<script>
// JavaScript removed as we're using direct form submission
</script>
@endpush
@endsection