@extends('user.layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow px-6 py-8">
            <!-- Order Header -->
            <div class="border-b border-gray-200 pb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Order #{{ $order->order_number }}
                    </h1>
                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $order->status_color }}">
                        {{ $order->status }}
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                </p>
            </div>

            <!-- Order Items -->
            <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-20 h-20">
                                <img src="{{ $item->product->primary_image_url }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-full h-full object-center object-cover rounded-lg">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('products.show', $item->product) }}" 
                                           class="hover:text-blue-600">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm font-medium text-gray-900">
                                        ₱{{ number_format($item->price * $item->quantity, 2) }}
                                    </p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Quantity: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}
                                </p>
                                @if($order->status === 'completed')
                                    <div class="mt-2">
                                        <a href="{{ route('reviews.create', ['product' => $item->product_id]) }}" 
                                           class="text-sm text-blue-600 hover:text-blue-500">
                                            Write a Review
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <p class="text-gray-600">Subtotal</p>
                        <p class="text-gray-900">₱{{ number_format($order->subtotal, 2) }}</p>
                    </div>
                    <div class="flex justify-between text-sm">
                        <p class="text-gray-600">Shipping</p>
                        <p class="text-gray-900">₱{{ number_format($order->shipping_fee, 2) }}</p>
                    </div>
                    <div class="flex justify-between text-base font-medium pt-2 border-t border-gray-200">
                        <p class="text-gray-900">Total</p>
                        <p class="text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="py-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="font-medium text-gray-900">Shipping Address</p>
                        <address class="mt-2 not-italic text-gray-600">
                            {{ $order->shipping_name }}<br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}<br>
                            Phone: {{ $order->shipping_phone }}
                        </address>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Payment Method</p>
                        <p class="mt-2 text-gray-600">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 flex justify-between items-center">
                <a href="{{ route('orders.index') }}" 
                   class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    ← Back to Orders
                </a>
                @if($order->status === 'processing' || $order->status === 'completed')
                    <a href="{{ route('orders.receipt', $order) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Download Receipt
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection