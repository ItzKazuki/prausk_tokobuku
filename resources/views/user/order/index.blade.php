@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
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

        <div class="flex items-center gap-4 mb-8">
            <h1 class="text-3xl font-bold italic">Pesanan Saya</h1>
            <div class="badge badge-outline">{{ $orders->count() }} Transaksi</div>
        </div>

        @forelse ($orders as $order)
            {{-- Card Per Pesanan --}}
            <div class="collapse collapse-arrow bg-base-100 border border-base-200 shadow-sm mb-4">
                <input type="checkbox" />

                {{-- Header Pesanan (Yang Terlihat Langsung) --}}
                <div class="collapse-title p-6">
                    <div class="flex flex-wrap justify-between items-center gap-4">
                        <div class="space-y-1">
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">ID Pesanan:
                                #{{ $order->code }}</p>
                            <p class="font-bold text-lg">Rp{{ number_format($order->amount, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>

                        <div class="flex items-center gap-3">
                            @switch($order->status)
                                @case('pending')
                                    <div class="badge badge-warning gap-2 p-3 font-medium">Pending</div>
                                @break

                                @case('processing')
                                    <div class="badge badge-info gap-2 p-3 font-medium text-white">Proses</div>
                                @break

                                @case('shipped')
                                    <div class="badge badge-accent gap-2 p-3 font-medium text-white">Dikirim</div>
                                @break

                                @case('success')
                                @case('completed')
                                    <div class="badge badge-success gap-2 p-3 font-medium text-white">Selesai</div>
                                @break

                                @case('cancelled')
                                    <div class="badge badge-error gap-2 p-3 font-medium text-white">Dibatalkan</div>
                                @break

                                @default
                                    <div class="badge badge-neutral gap-2 p-3 font-medium">Unknown</div>
                            @endswitch
                        </div>
                    </div>
                </div>

                {{-- Detail Pesanan (Muncul Saat Klik) --}}
                <div class="collapse-content bg-base-50/50">
                    <div class="divider mt-0"></div>
                    <div class="space-y-4">
                        @foreach ($order->orderDetails as $item)
                            <div class="flex items-center gap-4">
                                <div class="avatar">
                                    <div class="w-16 h-20 rounded-lg">
                                        <img src="{{ asset('storage/' . $item->book->image) }}"
                                            alt="{{ $item->book->title }}" class="object-cover" />
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm">{{ $item->book->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ $item->qty }} x
                                        Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-sm">
                                        Rp{{ number_format($item->qty * $item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer Detail --}}
                    <div class="mt-6 pt-4 border-t border-dashed border-base-300 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500 italic">Terima kasih telah berbelanja di Kabuku!</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="https://wa.me/62859102628529?text=Halo%2C%20saya%20mau%20tanya%20mengenai%20pesanan%20saya%20dengan%20nomor%20transaksi%20{{ $order->code }}"
                                target="_blank" class="btn btn-sm btn-primary">Tanya ke penjual</a>

                                @if ($order->snap_token)
                                    <a href="{{ route('user.order.pay', ['id' => $order->id]) }}" class="btn btn-success btn-sm">Bayar Sekarang</a>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
                {{-- State Jika Kosong --}}
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-base-200 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Belum ada pesanan</h3>
                    <p class="text-gray-500 mt-2">Sepertinya kamu belum pernah belanja buku di sini.</p>
                    <a href="{{ route('user.book.index') }}" class="btn btn-primary mt-6">Mulai Belanja</a>
                </div>
            @endforelse
        </div>
    @endsection
