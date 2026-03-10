<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($cart) {
            $cart->update(['qty' => $cart->qty + $request->qty]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
                'qty' => $request->qty,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        // Mengambil cart milik user yang sedang login beserta data bukunya
        $carts = Cart::with('book')->where('user_id', Auth::id())->get();

        return view('user.cart', compact('carts'));
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->back();
    }

    // public function checkout(Request $request)
    // {
    //     $validated = $request->validate([
    //         'pay' => 'required|integer',
    //         'payment_method' => 'required|in:cod,midtrans'
    //     ]);

    //     $carts = Cart::with('book')->where('user_id', Auth::id())->get();

    //     if ($carts->isEmpty()) {
    //         return redirect()->back()->with('error', 'Keranjang kosong!');
    //     }

    //     $totalAmount = $carts->sum(fn ($c) => $c->book->price * $c->qty);

    //     if($validated['pay'] < $totalAmount) {
    //         return redirect()->back()->with('error', 'Harga yang dibayar harus sesuai!');
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $order = Order::create([
    //             'user_id' => Auth::id(),
    //             'code' => 'TRX-'.strtoupper(Str::random(10)),
    //             'date' => now(),
    //             'amount' => $totalAmount,
    //             'pay' => $validated['pay'],
    //             'change' => 0,
    //             'status' => 'processing', // default is pending
    //         ]);

    //         foreach ($carts as $item) {
    //             OrderDetail::create([
    //                 'order_id' => $order->id,
    //                 'book_id' => $item->book_id,
    //                 'qty' => $item->qty,
    //                 'price' => $item->book->price,
    //                 'subtotal' => $item->book->price * $item->qty,
    //             ]);

    //             $item->book->decrement('stock', $item->qty);
    //         }

    //         Cart::where('user_id', Auth::id())->delete();

    //         DB::commit();

    //         return redirect()->route('user.order.index')->with('success', 'Checkout berhasil!');

    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
    //     }
    // }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cod,midtrans',
        ]);

        $carts = Cart::with('book')->where('user_id', Auth::id())->get();
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $totalAmount = $carts->sum(fn ($c) => $c->book->price * $c->qty);

        DB::beginTransaction();
        try {
            // 1. Buat Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'code' => 'TRX-'.strtoupper(Str::random(10)),
                'date' => now(),
                'amount' => $totalAmount,
                'pay' => $totalAmount,
                'change' => 0,
                'status' => 'processing',
            ]);

            // 2. Simpan Detail & Update Stok (Logic yang sudah kamu punya)
            foreach ($carts as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'qty' => $item->qty,
                    'price' => $item->book->price,
                    'subtotal' => $item->book->price * $item->qty,
                ]);
                $item->book->decrement('stock', $item->qty);
            }
            Cart::where('user_id', Auth::id())->delete();

            // 3. Percabangan Berdasarkan Metode Pembayaran
            if ($request->payment_method === 'midtrans') {
                // Konfigurasi Midtrans
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = false;
                Config::$isSanitized = true;

                $params = [
                    'transaction_details' => ['order_id' => $order->code, 'gross_amount' => $totalAmount],
                    'customer_details' => ['first_name' => Auth::user()->name, 'email' => Auth::user()->email],
                ];

                $order->update([
                    'status' => 'pending',
                ]);

                $snapToken = Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);

                DB::commit();

                return redirect()->route('user.order.pay', ['id' => $order->id]);
            }

            // Jika COD
            DB::commit();

            return redirect()->route('user.order.index')->with('success', 'Checkout berhasil! Pesanan diproses.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
