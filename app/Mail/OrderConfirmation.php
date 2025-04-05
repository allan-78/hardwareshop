<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class OrderConfirmation extends Mailable
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
        return $this->markdown('emails.order-confirmation')
            ->subject('Order Confirmation - #' . $this->order->id)
            ->attachData(
                $this->pdf->output(),
                'receipt.pdf',
                ['mime' => 'application/pdf']
            );
    }
}