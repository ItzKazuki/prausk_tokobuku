@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-5xl py-8">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Input Resi Pengiriman</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Ringkasan Pesanan --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card bg-base-100 border border-base-200 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-sm opacity-50 uppercase">Rincian Produk</h2>
                        <div class="divide-y divide-base-200">
                            @foreach ($order->orderDetails as $detail)
                                <div class="py-4 flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $detail->book->image) }}"
                                        class="w-12 h-16 object-cover rounded shadow-sm">
                                    <div class="flex-1">
                                        <p class="font-bold text-sm">{{ $detail->book->title }}</p>
                                        <p class="text-xs opacity-60">{{ $detail->qty }} pcs x
                                            Rp{{ number_format($detail->price, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-semibold text-sm">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-4 border-t flex justify-between items-center">
                            <span class="font-bold">Total Transaksi</span>
                            <span
                                class="text-xl font-bold text-primary">Rp{{ number_format($order->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 border border-base-200 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-sm opacity-50 uppercase">Informasi Pelanggan</h2>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <p class="text-xs opacity-50">Nama Penerima</p>
                                <p class="font-medium">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs opacity-50">Email</p>
                                <p class="font-medium">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Input Resi --}}
            <div class="space-y-6">
                <div class="card bg-base-100 border border-primary shadow-md">
                    <div class="card-body">
                        <h2 class="card-title text-primary italic">Konfirmasi Pengiriman</h2>
                        <p class="text-xs opacity-70">Masukkan nomor resi kurir untuk memberitahu pembeli bahwa buku sedang
                            dikirim.</p>

                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mt-4 space-y-4">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="status" value="shipped">

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-bold">Nomor Resi (Tracking Number)</span>
                                </label>
                                <input type="text" name="tracking_number"
                                    class="input input-bordered w-full @error('tracking_number') input-error @enderror"
                                    placeholder="Contoh: JNE123456789"
                                    value="{{ old('tracking_number', $order->tracking_number) }}" required autofocus />
                                @error('tracking_number')
                                    <label class="label"><span
                                            class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary btn-block shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Kirim Pesanan
                                </button>
                                <p class="text-[10px] text-center mt-3 opacity-50 italic">*Status otomatis berubah menjadi
                                    'Dikirim'</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
