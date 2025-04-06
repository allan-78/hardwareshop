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
                    $buttons = '<a href="'.route('admin.orders.show', $order->id).'" class="btn btn-sm btn-primary">View</a>';
                    
                    if ($order->status === 'pending') {
                        $buttons .= ' <button class="btn btn-sm btn-success mark-completed" data-id="'.$order->id.'">Mark Completed</button>';
                    }
                    
                    return $buttons;
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
    
    public function markAsCompleted(Order $order)
    {
        $order->update(['status' => 'completed']);
        
        // Send email notification
        Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
        
        return response()->json(['success' => true]);
    }
}