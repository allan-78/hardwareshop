<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalSales = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get sales data for chart
        $salesData = Order::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('month')
            ->get();

        // Prepare sales chart data
        $salesChart = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'data' => array_fill(0, 12, 0)
                ]
            ]
        ];

        foreach ($salesData as $data) {
            $salesChart['datasets'][0]['data'][$data->month - 1] = $data->total;
        }

        // Get product sales data
        $productSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->select(
                'products.id',
                'products.name as product.name',
                DB::raw('SUM(order_items.quantity * order_items.price) as total')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'salesChart',
            'productSales'
        ));
    }

    public function salesData(Request $request)
    {
        $startDate = $request->input('start', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end', Carbon::now()->format('Y-m-d'));

        // Get sales data for the date range
        $salesData = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->get();

        // Get product sales data for the date range
        $productSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity * order_items.price) as total')
            )
            ->groupBy('products.name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'salesData' => $salesData,
            'productSales' => $productSales
        ]);
    }

    public function salesReport(Request $request)
    {
        // Implementation for sales report
        // ...
    }

    public function productsReport(Request $request)
    {
        // Implementation for products report
        // ...
    }
}