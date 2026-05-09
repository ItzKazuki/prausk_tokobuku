@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        @if (session('success'))
            <div role="alert" class="alert alert-success shadow-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error shadow-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Daftar Transaksi</h1>
            <p class="text-sm text-gray-500">
                Hari ini: {{ now()->translatedFormat('l, d F Y') }}
            </p>

            <div class="flex flex-row gap-4">
                <form method="get ">
                    <input type="text" name="search" placeholder="Cari transaksi" class="input" />
                </form>

                <a class="btn btn-error" href="{{ route('admin.report.index') }}">Laporan Penjualan</a>
            </div>
        </div>

        <div>

        </div>

        <div class="overflow-x-auto bg-base-100 rounded-box shadow-sm border border-base-200">
            <table class="table table-zebra w-full">
                <thead>
                    <tr class="bg-base-200">
                        <th>No</th>
                        <th>Kode & Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <div class="font-bold text-primary tracking-wide">{{ $order->code }}</div>
                                {{-- Memformat tanggal agar lebih user-friendly --}}
                                <div class="text-xs opacity-60">
                                    {{ \Carbon\Carbon::parse($order->date)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>
                                <div class="font-medium leading-none">{{ $order->user->name }}</div>
                                <div class="text-[10px] opacity-50 mt-1">{{ $order->user->email }}</div>
                            </td>
                            <td class="font-mono font-semibold text-base-content/80">
                                Rp{{ number_format($order->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge badge-warning badge-sm font-medium">Pending</span>
                                    @break

                                    @case('processing')
                                        <span class="badge badge-info badge-sm font-medium">Proses</span>
                                    @break

                                    @case('shipped')
                                        <span class="badge badge-accent badge-sm font-medium text-white">Dikirim</span>
                                    @break

                                    @case('completed')
                                        <span class="badge badge-success badge-sm font-medium text-white">Selesai</span>
                                    @break

                                    @default
                                        <span class="badge badge-error badge-sm font-medium text-white">Batal</span>
                                @endswitch
                            </td>
                            <td>
                                {{-- Gunakan flex agar tombol rapi --}}
                                <div class="flex flex-wrap items-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-ghost btn-xs text-info hover:bg-info/10">
                                        Detail
                                    </a>

                                    {{-- Tombol Tambah Resi --}}
                                    @if ($order->status == 'processing')
                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="btn btn-xs btn-primary shadow-sm">
                                            Tambah Resi
                                        </a>
                                    @endif

                                    {{-- Tombol Batalkan Transaksi --}}
                                    @if ($order->status == 'processing' || $order->status == 'pending')
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button class="btn btn-xs btn-error btn-outline shadow-sm" type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Selesaikan --}}
                                    @if ($order->status == 'shipped')
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-xs btn-success text-white shadow-sm">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Invoice --}}
                                    <a href="{{ route('invoices.order.show', ['orderNumber' => $order->code]) }}"
                                        class="btn btn-xs btn-ghost border border-base-300">
                                        Invoice
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-400 italic">
                                    Belum ada transaksi masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
