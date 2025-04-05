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
            $orders = Order::with(['user', 'items.product']);
            
            return DataTables::of($orders)
                ->addColumn('action', function ($order) {
                    return view('admin.orders.actions', compact('order'));
                })
                ->editColumn('total_amount', function ($order) {
                    return '₱' . number_format($order->total_amount, 2);
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y H:i');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.orders.index');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);
        
        // Send email notification
        Mail::to($order->user->email)->send(new OrderStatusUpdated($order));

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function generatePDF(Order $order)
    {
        $order->load(['user', 'items.product']);
        $pdf = PDF::loadView('pdf.receipt', compact('order'));
        return $pdf->download('order-'.$order->id.'.pdf');
    }
}