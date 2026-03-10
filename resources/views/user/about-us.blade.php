@extends('layouts.app')

@section('content')
    <div class="space-y-20 pb-20">

        {{-- 1. Hero Section: Branding --}}
        <div class="hero min-h-[60vh] rounded-3xl overflow-hidden"
            style="background-image: url(https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80);">
            <div class="hero-overlay bg-opacity-70 bg-indigo-900/60"></div>
            <div class="hero-content text-center text-neutral-content">
                <div class="max-w-md">
                    <h1 class="mb-5 text-5xl font-bold italic">Kabuku.</h1>
                    <p class="mb-5 text-lg">Membangun peradaban melalui jendela dunia. Kami hadir untuk mendekatkan literasi
                        ke genggaman Anda dengan kurasi buku terbaik dan harga yang jujur.</p>
                    <button class="btn btn-primary">Pelajari Visi Kami</button>
                </div>
            </div>
        </div>

        {{-- 4. Value Proposition: Grid --}}
        <div class="bg-base-200 -mx-4 px-8 py-20 rounded-[3rem]">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold italic">Komitmen Kami</h2>
                <div class="divider w-24 mx-auto divider-primary"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="card bg-base-100 shadow-sm p-6 space-y-4 border-b-4 border-primary">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 flex items-center justify-center rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Harga Kompetitif</h3>
                    <p class="text-sm text-gray-500">Bekerja sama langsung dengan distributor besar untuk memastikan harga
                        terbaik bagi pelanggan.</p>
                </div>

                <div class="card bg-base-100 shadow-sm p-6 space-y-4">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 flex items-center justify-center rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Layanan Ramah</h3>
                    <p class="text-sm text-gray-500">Tim support kami siap membantu Anda menemukan rekomendasi buku yang
                        paling cocok.</p>
                </div>
            </div>
        </div>

        {{-- 5. Call to Action --}}
        <div class="text-center space-y-6 py-10">
            <h2 class="text-3xl font-bold italic">Siap Menemukan Petualangan Baru?</h2>
            <a href="{{ route('user.book.index') }}" class="btn btn-primary btn-wide rounded-full">Mulai Belanja
                Sekarang</a>
        </div>

    </div>
@endsection
