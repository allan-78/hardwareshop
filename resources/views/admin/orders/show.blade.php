@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <h3 class="text-gray-700 text-3xl font-medium">Order #{{ $order->order_number }}</h3>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
            Back to Orders
        </a>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Order Information -->
        <div class="col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Order Details</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select rounded-l-md">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700">
                                Update
                            </button>
                        </form>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mt-6 bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ $item->product->primary_image_url }}" 
                                             alt="{{ $item->product->name }}"
                                             class="h-12 w-12 object-cover rounded-lg mr-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₱{{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₱{{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                                <td class="px-6 py-3 text-sm text-gray-900">₱{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Shipping Fee</td>
                                <td class="px-6 py-3 text-sm text-gray-900">₱{{ number_format($order->shipping_fee, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-medium text-gray-700 mb-4">Customer Information</h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="text-gray-900">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-gray-900">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="text-gray-900">{{ $order->shipping_phone }}</p>
                    </div>
                </div>

                <h4 class="text-lg font-medium text-gray-700 mt-6 mb-4">Shipping Address</h4>
                <div class="space-y-2">
                    <p class="text-gray-900">{{ $order->shipping_address }}</p>
                    <p class="text-gray-900">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                    <p class="text-gray-900">{{ $order->shipping_postal_code }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection