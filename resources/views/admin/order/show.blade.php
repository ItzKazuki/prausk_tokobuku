@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-8 px-4 space-y-6">
        {{-- Header & Tombol Kembali --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-circle btn-ghost btn-sm border border-base-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold italic">{{ $order->code }}</h1>
                    <p class="text-xs opacity-60 uppercase tracking-widest font-semibold">
                        {{ \Carbon\Carbon::parse($order->date)->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Status Badge Dinamis --}}
                @switch($order->status)
                    @case('pending')
                        <div class="badge badge-warning p-4 font-bold">Pending</div>
                    @break

                    @case('processing')
                        <div class="badge badge-info p-4 font-bold text-white">Proses</div>
                    @break

                    @case('shipped')
                        <div class="badge badge-accent p-4 font-bold text-white">Dikirim</div>
                    @break

                    @case('completed')
                        <div class="badge badge-success p-4 font-bold text-white">Selesai</div>
                    @break

                    @default
                        <div class="badge badge-error p-4 font-bold text-white">Batal</div>
                @endswitch

                <button onclick="window.print()" class="btn btn-ghost btn-sm border border-base-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>

                <a href="{{ route('invoices.order.show', ['orderNumber' => $order->code]) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-ghost border border-base-300">Invoice</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri: Daftar Produk --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card bg-base-100 border border-base-200 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-sm opacity-50 mb-4">ITEM YANG DIBELI</h3>
                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead>
                                    <tr class="text-xs uppercase opacity-60">
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-right">Harga Satuan</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-base-100">
                                    @foreach ($order->orderDetails as $item)
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar">
                                                        <div class="mask mask-squircle w-12 h-16">
                                                            <img src="{{ asset('storage/' . $item->book->image) }}"
                                                                alt="{{ $item->book->title }}" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-sm">{{ $item->book->title }}</div>
                                                        <div class="text-xs opacity-50">{{ $item->book->author }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center font-semibold">{{ $item->qty }}</td>
                                            <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-right font-bold">
                                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right text-lg">Total Bayar</th>
                                        <th class="text-right text-lg text-primary font-extrabold italic">
                                            Rp{{ number_format($order->amount, 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Info Pembeli & Tracking --}}
            <div class="space-y-6">
                {{-- Card Profil Pembeli --}}
                <div class="card bg-base-100 border border-base-200 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-sm opacity-50 mb-2">DETAIL PELANGGAN</h3>
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="w-12 rounded-full">
                                    <img src="{{ $order->user->avatar_url }}" />
                                </div>
                            </div>
                            <div>
                                <p class="font-bold">{{ $order->user->name }}</p>
                                <p class="text-xs opacity-60">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Logistik/Resi --}}
                <div class="card bg-base-100 border border-base-200 shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-sm opacity-50 mb-2">LOGISTIK</h3>
                        <div>
                            <p class="text-xs opacity-50 uppercase">Nomor Resi</p>
                            @if ($order->tracking_number)
                                <div class="flex items-center justify-between mt-1">
                                    <span class="font-mono font-bold text-primary">{{ $order->tracking_number }}</span>
                                    <div class="badge badge-outline badge-xs italic">Shipped</div>
                                </div>
                            @else
                                <p class="text-sm italic text-gray-400 mt-1">Resi belum diinput</p>
                                @if ($order->status == 'processing')
                                    <a href="{{ route('admin.orders.edit', $order->id) }}"
                                        class="btn btn-xs btn-primary mt-3">Input Resi Sekarang</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Pembayaran --}}
                <div class="card bg-primary text-primary-content shadow-lg shadow-primary/20">
                    <div class="card-body p-6">
                        <h3 class="text-xs uppercase font-bold opacity-70 mb-4">Status Pembayaran</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Tagihan</span>
                                <span class="font-bold">Rp{{ number_format($order->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Dibayar</span>
                                <span class="font-bold">Rp{{ number_format($order->pay, 0, ',', '.') }}</span>
                            </div>
                            <div class="divider divider-neutral opacity-20"></div>
                            <div class="flex justify-between font-bold">
                                <span>Kembalian</span>
                                <span>Rp{{ number_format($order->change, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
