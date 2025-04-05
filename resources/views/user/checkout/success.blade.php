@extends('user.layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow px-6 py-8">
            <!-- Success Header -->
            <div class="text-center">
                <div class="rounded-full bg-green-100 h-16 w-16 flex items-center justify-center mx-auto">
                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="mt-4 text-3xl font-extrabold text-gray-900">Thank You for Your Order!</h1>
                <p class="mt-2 text-lg text-gray-600">
                    Order #{{ $order->order_number }}
                </p>
            </div>

            <!-- Order Details -->
            <div class="mt-8">
                <div class="border-t border-b border-gray-200 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Order Details</h2>
                    <dl class="mt-4 space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Order Date</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                {{ $order->created_at->format('F d, Y h:i A') }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Payment Method</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                {{ ucfirst($order->payment_method) }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Order Status</dt>
                            <dd class="text-sm font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Processing
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Shipping Address -->
                <div class="border-b border-gray-200 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Shipping Address</h2>
                    <address class="mt-4 text-sm text-gray-600 not-italic">
                        {{ $order->shipping_name }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                        Phone: {{ $order->shipping_phone }}
                    </address>
                </div>

                <!-- Order Summary -->
                <div class="py-4">
                    <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                    <ul class="mt-4 divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <li class="py-4 flex">
                                <div class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden">
                                    <img src="{{ $item->product->primary_image_url }}" 
                                         alt="{{ $item->product->name }}"
                                         class="w-full h-full object-center object-cover">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ $item->product->name }}
                                        </h3>
                                        <p class="text-sm font-medium text-gray-900">
                                            ₱{{ number_format($item->price * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between text-sm">
                            <p class="text-gray-600">Subtotal</p>
                            <p class="font-medium text-gray-900">₱{{ number_format($order->subtotal, 2) }}</p>
                        </div>
                        <div class="flex justify-between text-sm">
                            <p class="text-gray-600">Shipping</p>
                            <p class="font-medium text-gray-900">₱{{ number_format($order->shipping_fee, 2) }}</p>
                        </div>
                        <div class="border-t border-gray-200 pt-4 flex justify-between">
                            <p class="text-base font-medium text-gray-900">Total</p>
                            <p class="text-base font-medium text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="mt-8 space-y-4">
                <div class="bg-blue-50 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">What's Next?</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>You will receive an order confirmation email shortly</li>
                                    <li>We will notify you when your order has been shipped</li>
                                    <li>Track your order status in your account dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center space-x-4">
                    <a href="{{ route('orders.show', $order) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        View Order Details
                    </a>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection