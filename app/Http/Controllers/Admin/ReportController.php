<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $orders = Order::with(['user', 'orderDetails.book'])
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->where('status', 'completed')
            ->latest()
            ->get();

        $total_revenue = $orders->sum('amount');

        return view('admin.report.index', compact('orders', 'total_revenue', 'start_date', 'end_date'));
    }
}
