@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>

    <div class="mt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Sales Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <x-icon name="currency-dollar" class="h-8 w-8 text-blue-600"/>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Sales</p>
                        <p class="text-lg font-semibold text-gray-700">₱{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <x-icon name="shopping-cart" class="h-8 w-8 text-green-600"/>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Orders</p>
                        <p class="text-lg font-semibold text-gray-700">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <x-icon name="shopping-bag" class="h-8 w-8 text-yellow-600"/>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Products</p>
                        <p class="text-lg font-semibold text-gray-700">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <x-icon name="users" class="h-8 w-8 text-purple-600"/>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-lg font-semibold text-gray-700">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-gray-700 text-lg font-medium mb-4">Sales Overview</h4>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-gray-700 text-lg font-medium mb-4">Top Categories</h4>
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h4 class="text-gray-700 text-lg font-medium">Recent Orders</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/charts.js') }}"></script>
<script>
    const salesData = @json($salesChart);
    const categoryData = @json($categoryChart);
</script>
@endpush