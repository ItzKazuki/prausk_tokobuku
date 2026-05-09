<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua order, diurutkan dari yang terbaru
        $orders = Order::with('user')->latest()->get();

        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'orderDetails.book'])->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['user', 'orderDetails.book'])->findOrFail($id);

        return view('admin.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string|in:shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $order = Order::findOrFail($id);

        if ($order->status === 'completed') {
            return redirect()->back()->with('error', 'Status order tidak dapat diubah!');
        }

        $data = $request->only(['status', 'tracking_number']);

        $filteredData = array_filter($data, fn ($value) => ! is_null($value));

        if ($request->status === 'cancelled') {
            DB::transaction(function () use ($order) {
                foreach ($order->orderDetails as $detail) {
                    $detail->book->increment('stock', $detail->qty);
                }

                $order->update(['status' => 'cancelled']);
            });
        } else {
            $order->update($filteredData);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Status berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
