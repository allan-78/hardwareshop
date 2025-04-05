@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <!-- Sales Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Sales</h6>
                            <h2 class="card-title mb-0">₱{{ number_format($totalSales, 2) }}</h2>
                        </div>
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Orders</h6>
                            <h2 class="card-title mb-0">{{ $totalOrders }}</h2>
                        </div>
                        <i class="bi bi-cart fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Products</h6>
                            <h2 class="card-title mb-0">{{ $totalProducts }}</h2>
                        </div>
                        <i class="bi bi-box fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Users</h6>
                            <h2 class="card-title mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales Overview</h5>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Categories</h5>
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Recent Orders</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $order->status === 'completed' ? 'success' : 
                                    ($order->status === 'pending' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesData = @json($salesChart);
    const categoryData = @json($categoryChart);

    // Initialize Charts
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: salesData,
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('categoriesChart'), {
        type: 'doughnut',
        data: categoryData,
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush