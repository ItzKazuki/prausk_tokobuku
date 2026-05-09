@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4 space-y-6">
        <h1 class="text-2xl font-bold">Edit Buku</h1>

        <div class="flex flex-col md:flex-row gap-8">
            <form action="{{ route('admin.books.update', ['book' => $book->id]) }}" method="post"
                enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Judul Buku --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Judul Buku</legend>
                    <input type="text" name="title" class="input w-full @error('title') border-error @enderror"
                        value="{{ old('title', $book->title) }}" placeholder="Contoh: Laskar Pelangi" />
                    @error('title')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </fieldset>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Kategori --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Kategori</legend>
                        <select name="category_id" class="select w-full @error('category_id') border-error @enderror">
                            <option disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $book->category->id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    {{-- Penulis --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Penulis</legend>
                        <input type="text" name="author" class="input w-full @error('author') border-error @enderror"
                            value="{{ old('author', $book->author) }}" placeholder="Nama Penulis" />
                        @error('author')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror
                    </fieldset>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Harga --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Harga</legend>
                        <input type="number" name="price" class="input w-full @error('price') border-error @enderror"
                            value="{{ old('price', $book->price) }}" placeholder="50000" />
                        @error('price')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    {{-- Stok --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Stok</legend>
                        <input type="number" name="stock" class="input w-full @error('stock') border-error @enderror"
                            value="{{ old('stock', $book->stock) }}" placeholder="10" />
                        @error('stock')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror
                    </fieldset>
                </div>

                {{-- Deskripsi --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Deskripsi</legend>
                    <textarea name="description" class="textarea w-full h-24 @error('description') border-error @enderror"
                        placeholder="Sinopsis buku...">{{ old('description', $book->description) }}</textarea>
                    @error('description')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </fieldset>

                {{-- Cover Buku --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Cover Buku (JPG, PNG, WEBP - Max 2MB)</legend>
                    <input type="file" name="image" id="imageInput" class="file-input w-full @error('image') border-error @enderror" />
                    @error('image')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </fieldset>

                <div class="pt-4">
                    <button class="btn btn-info w-full" type="submit">
                        Simpan Buku Baru
                    </button>
                </div>
            </form>

            {{-- Bagian Preview Gambar --}}
            <div class="w-full md:w-64">
                <p class="text-sm font-semibold mb-2 text-gray-500">Preview Cover:</p>
                <div
                    class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden h-80 flex items-center justify-center bg-gray-50">
                    {{-- Tag img untuk menampilkan gambar --}}
                    <img id="imagePreview" src="{{ $book->image ? asset('storage/' . $book->image) : '' }}"
                        class="w-full h-full object-cover {{ $book->image ? '' : 'hidden' }}">

                    {{-- Placeholder jika tidak ada gambar --}}
                    <div id="placeholder" class="text-center p-4 {{ $book->image ? 'hidden' : '' }}">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 48 48">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-xs text-gray-400 mt-2">Belum ada gambar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Handle Preview --}}
    <script>
        // Ambil elemen yang dibutuhkan
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('placeholder');

        // Event listener saat input file berubah
        imageInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Masukkan hasil pembacaan file ke src img
                    imagePreview.src = e.target.result;
                    // Tampilkan gambar, sembunyikan placeholder
                    imagePreview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                // Jika user membatalkan pilihan file, kembalikan ke kondisi awal atau kosong
                // Tergantung kebutuhan, di sini kita biarkan gambar lama tetap tampil jika ada
            }
        });
    </script>
@endsection