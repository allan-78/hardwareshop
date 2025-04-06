<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\OrderItem; // Add this import
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    public function index(Request $request)
    {
        // Calculate total sales
        $totalSales = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'user')->count();

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

        // Prepare sales chart data
        $salesChart = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Monthly Sales',
                    'data' => array_fill(0, 12, 0), // Initialize with zeros
                    'borderColor' => '#4e73df',
                    'tension' => 0.3
                ]
            ]
        ];

        // Fill in actual sales data
        foreach ($salesData as $data) {
            $salesChart['datasets'][0]['data'][$data->month - 1] = $data->total;
        }

        // Prepare category chart data
        $categoryData = [
            'labels' => ['Electronics', 'Tools', 'Hardware', 'Others'],
            'datasets' => [
                [
                    'data' => [30, 25, 25, 20],
                    'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
                ]
            ]
        ];

        return view('admin.dashboard.index', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'salesData',
            'productSales',
            'recentOrders',
            'salesChart',
            'categoryData'
        ));
    }

    public function salesData(Request $request)
    {
        $startDate = $request->get('start', now()->subDays(30));
        $endDate = $request->get('end', now());

        $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $productSales = OrderItem::whereBetween('created_at', [$startDate, $endDate])
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.total) as total')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json([
            'salesData' => $salesData,
            'productSales' => $productSales
        ]);
    }
}