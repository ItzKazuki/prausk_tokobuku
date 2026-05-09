@extends('layouts.landing')

@section('content')
    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50 px-4 md:px-20">
        <div class="flex-1">
            <a class="text-2xl font-bold text-primary tracking-tighter">Ka<span class="text-base-content">buku</span></a>
        </div>
        <div class="flex-none gap-2">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard.index') : route('user.dashboard.index') }}"
                    class="btn btn-primary btn-outline btn-sm md:btn-md">
                    Ke Dashboard
                </a>
            @else
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm md:btn-md font-bold">Masuk</a>
                    <a href="{{ route('register.create') }}" class="btn btn-primary btn-sm md:btn-md shadow-md">Daftar
                        Sekarang</a>
                </div>
            @endauth
        </div>
    </div>

    <div class="hero min-h-[60vh] bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-2xl">
                <h1 class="text-5xl font-bold">Temukan Buku Yang Kamu Cari</h1>
                <p class="py-6 text-lg text-base-content/70">Mulai dari fiksi yang memikat hingga ilmu pengetahuan yang
                    mendalam. Koleksi buku terlengkap dengan harga terbaik untuk menemani waktu luangmu.</p>
                <div class="flex justify-center gap-3">
                    <a href="#buku" class="btn btn-primary px-8">Jelajahi Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <div id="buku" class="container mx-auto px-4 py-16 md:px-20">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold">Koleksi Terbaru</h2>
                <p class="text-base-content/60">Buku-buku pilihan yang baru saja tiba di rak kami.</p>
            </div>
            <a href="{{ route('user.book.index') }}" class="link link-primary font-semibold">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach ($books as $item)
                <div
                    class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-xl transition-all duration-300 group">
                    <figure class="px-4 pt-4 relative">
                        <img src="{{ $item->image_url }}" alt="Book Cover"
                            class="rounded-xl h-64 w-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="badge badge-secondary absolute top-6 right-6">Baru</div>
                    </figure>
                    <div class="card-body p-4">
                        <h2 class="card-title text-sm md:text-base leading-tight">{{ $item->title }}</h2>
                        <p class="text-xs text-base-content/60">{{ $item->author }}</p>
                        <div class="mt-2">
                            <span
                                class="text-lg font-bold text-primary font-mono">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="card-actions mt-3">
                            <a href="{{ route('user.book.index') }}" class="btn btn-primary btn-sm btn-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <footer class="footer p-10 bg-neutral text-neutral-content">
        <aside>
            <span class="text-2xl font-bold text-white tracking-tighter mb-2 italic">Kabuku</span>
            <p>Memberikan akses jual buku terbaik sejak 2025.<br />Copyright © 2025 - All right reserved</p>
        </aside>
    </footer>
@endsection
