<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    // Menampilkan invoice di browser (Web View)
    public function show(string $orderNumber)
    {
        $order = Order::with(['orderDetails.book.category', 'user'])
            ->where('code', $orderNumber)->firstOrFail();

        return view('invoices.show', compact('order'));
    }

    // Mendownload invoice sebagai PDF
    public function download($orderNumber)
    {
        $order = Order::with(['orderDetails.book.category', 'user'])
            ->where('code', $orderNumber)->firstOrFail();

        // Load view yang sama tapi diconvert ke PDF
        $pdf = Pdf::loadView('invoices.show', compact('order'));

        return $pdf->download('invoice-'.$order->code.'.pdf');
    }
}
