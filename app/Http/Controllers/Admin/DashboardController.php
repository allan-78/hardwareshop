<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    public function index(Request $request)
    {
        // Stats for cards
        $stats = [
            'total_sales' => Order::where('status', 'completed')->sum('total_amount'),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'user')->count(),
        ];

        // Chart data
        $salesData = Order::where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) month, SUM(total_amount) total')
            ->groupBy('month')
            ->get();

        // Product sales percentage
        $productSales = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats', 
            'salesData', 
            'productSales', 
            'recentOrders'
        ));
    }
}