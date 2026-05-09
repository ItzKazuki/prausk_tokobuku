@extends('layouts.app')

@section('content')
    <div class="p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold tracking-tight">Laporan Penjualan</h2>

            {{-- Ringkasan Pendapatan menggunakan DaisyUI Stats --}}
            <div class="stats shadow bg-success text-success-content">
                <div class="stat py-2 px-6">
                    <div class="stat-title text-success-content/70">Total Pendapatan</div>
                    <div class="stat-value text-2xl">Rp {{ number_format($total_revenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Filter Form --}}
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body p-4">
                <form action="{{ route('admin.report.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="form-control w-full max-w-xs">
                        <label class="label"><span class="label-text font-semibold">Tanggal Mulai</span></label>
                        <input type="date" name="start_date" class="input input-bordered w-full"
                            value="{{ $start_date }}">
                    </div>

                    <div class="form-control w-full max-w-xs">
                        <label class="label"><span class="label-text font-semibold">Tanggal Selesai</span></label>
                        <input type="date" name="end_date" class="input input-bordered w-full"
                            value="{{ $end_date }}">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.report.index') }}" class="btn btn-ghost border-base-300">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="overflow-x-auto bg-base-100 rounded-box shadow-sm border border-base-200">
            <table class="table table-zebra w-full">
                <thead>
                    <tr class="bg-base-200 text-base-content">
                        <th class="w-12">No</th>
                        <th>Detail Transaksi</th>
                        <th>Customer</th>
                        <th>Buku yang Dibeli</th>
                        <th class="text-center">Total Item</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="hover">
                            <th class="text-center font-normal opacity-70">{{ $loop->iteration }}</th>
                            <td>
                                <div class="font-bold text-primary">{{ $order->code }}</div>
                                <div class="text-xs opacity-60">
                                    {{ \Carbon\Carbon::parse($order->date)->translatedFormat('d M Y') }}</div>
                            </td>
                            <td>
                                <div class="font-medium">{{ $order->user->name }}</div>
                                <div class="text-[10px] opacity-50">{{ $order->user->email }}</div>
                            </td>
                            <td>
                                <ul class="list-disc list-inside text-sm space-y-1">
                                    @foreach ($order->orderDetails as $detail)
                                        <li>
                                            <span class="font-medium">{{ $detail->book->title }}</span>
                                            <span class="badge badge-ghost badge-sm font-mono">{{ $detail->qty }}x</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <span class="font-semibold">{{ $order->orderDetails->sum('qty') }}</span>
                            </td>
                            <td class="text-right font-mono font-bold text-base-content/80">
                                Rp {{ number_format($order->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center opacity-30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="italic">Tidak ada data untuk periode ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
