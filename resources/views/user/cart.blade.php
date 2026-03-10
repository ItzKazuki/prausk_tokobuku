@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
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

        <h1 class="text-3xl font-bold mb-8 italic">Keranjang</h1>

        @if ($carts->isEmpty())
            <div class="text-center py-20 bg-base-200 rounded-3xl">
                <p class="text-xl text-gray-500">Wah, keranjangmu masih kosong nih.</p>
                <a href="{{ route('user.book.index') }}" class="btn btn-primary mt-4">Cari Buku Sekarang</a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Daftar Item --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($carts as $item)
                        <div class="card card-side bg-base-100 shadow-sm border border-base-200 h-32">
                            <figure class="w-24 h-full shrink-0">
                                <img src="{{ asset('storage/' . $item->book->image) }}"
                                    class="h-full w-full object-cover" />
                            </figure>
                            <div class="card-body p-4 flex-row justify-between items-center w-full">
                                <div>
                                    <h2 class="card-title text-md">{{ $item->book->title }}</h2>
                                    <p class="text-primary font-bold">Rp{{ number_format($item->book->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-400">Jumlah: {{ $item->qty }}</p>
                                </div>
                                <div class="card-actions">
                                    <form action="{{ route('user.cart.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-circle btn-ghost btn-sm text-error">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan Belanja --}}
                <div class="card bg-base-100 shadow-xl border border-base-200 h-fit">
                    <div class="card-body">
                        <h2 class="card-title border-b pb-4">Ringkasan Belanja</h2>
                        <div class="space-y-2 mt-4">
                            <div class="flex justify-between">
                                <span>Total Item</span>
                                <span>{{ $carts->sum('qty') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-xl mt-4 border-t pt-4">
                                <span>Total Harga</span>
                                <span class="text-primary">
                                    Rp{{ number_format($carts->sum(fn($c) => $c->book->price * $c->qty), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-actions mt-6">
                            <form action="{{ route('user.checkout.store') }}" method="POST" class="w-full">
                                @csrf
                                <fieldset class="fieldset">
                                    <legend class="fieldset-legend">Metode Pembayaran</legend>
                                    <select name="payment_method"
                                        class="select w-full @error('payment_method') border-error @enderror">
                                        <option disabled selected>Pilih Metode Pembayaran</option>
                                        <option value="cod">
                                            Cash on Delivery
                                        </option>
                                        <option value="midtrans">
                                            Midtrans
                                        </option>
                                    </select>
                                    @error('payment_method')
                                        <span class="text-error text-sm">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <button type="submit" class="btn btn-primary btn-block shadow-lg">
                                    Konfirmasi Pesanan
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

