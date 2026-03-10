@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 space-y-12 py-8">
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

        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold flex items-center gap-2">
                    Buku Yang Tersedia
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($books as $book)
                    <div
                        class="card bg-base-100 shadow-md hover:shadow-2xl transition-all duration-300 border border-base-200">
                        <figure class="px-4 pt-4">
                            <img src="{{ $book->image ? asset('storage/' . $book->image) : 'https://placehold.co/400x600?text=No+Cover' }}"
                                alt="{{ $book->title }}" class="rounded-xl w-full object-cover shadow-sm" />
                        </figure>

                        <div class="card-body p-5">
                            <div class="badge badge-secondary badge-outline text-xs mb-1">
                                {{ $book->category->name ?? 'General' }}</div>
                            <h2 class="card-title text-lg leading-tight line-clamp-1" title="{{ $book->title }}">
                                {{ $book->title }}
                            </h2>
                            <p class="text-sm text-gray-500 italic mb-2">oleh {{ $book->author }}</p>

                            <p class="text-sm text-gray-600 line-clamp-2 min-h-10">
                                {{ $book->description }}
                            </p>

                            <div class="flex items-center justify-between mt-4">
                                <span
                                    class="text-xl font-bold text-primary">Rp{{ number_format($book->price, 0, ',', '.') }}</span>
                                <span class="text-xs text-gray-400">Stok: {{ $book->stock }}</span>
                            </div>

                            <div class="card-actions mt-4">
                                {{-- Form untuk tambah ke keranjang --}}
                                <form action="{{ route('user.cart.store') }}" method="POST" class="w-full">
                                    @csrf
                                    {{-- ID Buku yang akan dibeli --}}
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                                    {{-- Default Qty adalah 1 --}}
                                    <input type="hidden" name="qty" value="1">

                                    {{-- Cek Stok: Jika stok 0, disable tombolnya --}}
                                    @if ($book->stock > 0)
                                        <button type="submit" class="btn btn-primary btn-block gap-2 group">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Beli Sekarang
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-disabled btn-block gap-2">
                                            Stok Habis
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center">
                        <p class="text-gray-400">Belum ada buku tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
