<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    protected $pdf;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->pdf = PDF::loadView('pdf.receipt', ['order' => $order]);
    }

    public function build()
    {
        return $this->markdown('emails.order-status-updated')
            ->subject('Order Status Updated - #' . $this->order->id)
            ->with([
                'orderNumber' => $this->order->id,
                'newStatus' => $this->order->status,
                'orderDate' => $this->order->created_at->format('M d, Y'),
                'totalAmount' => $this->order->total_amount
            ])
            ->attachData(
                $this->pdf->output(),
                'receipt.pdf',
                ['mime' => 'application/pdf']
            );
    }
}