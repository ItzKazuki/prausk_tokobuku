<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderDetails.book')->get();

        return view('user.order.index', compact('orders'));
    }

    public function payment(string $id)
    {
        $order = Order::findOrFail($id);

        // Pastikan order milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika order sudah dibayar, jangan tampilkan halaman bayar lagi
        if ($order->status === 'processing') {
            return redirect()->route('user.order.index')->with('info', 'Order sudah dibayar.');
        }

        return view('user.order.payment', compact('order'));
    }
}
