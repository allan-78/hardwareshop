<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Mail;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends AdminController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('user');
            
            return DataTables::of($orders)
                ->addColumn('action', function ($order) {
                    return view('admin.orders.actions', compact('order'));
                })
                ->editColumn('status', function ($order) {
                    return ucfirst($order->status);
                })
                ->editColumn('total_amount', function ($order) {
                    return '₱' . number_format($order->total_amount, 2);
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y H:i');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        // Get orders with pagination for non-AJAX requests
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
}