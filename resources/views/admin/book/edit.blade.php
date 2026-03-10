@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4 space-y-6">
        <h1 class="text-2xl font-bold">Edit Buku</h1>

        <form action="{{ route('admin.books.update', ['book' => $book->id]) }}" method="post" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Judul Buku --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Judul Buku</legend>
                <input type="text" name="title" class="input w-full @error('title') border-error @enderror" value="{{ old('title', $book->title) }}" placeholder="Contoh: Laskar Pelangi" />
                @error('title') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </fieldset>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Kategori --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Kategori</legend>
                    <select name="category_id" class="select w-full @error('category_id') border-error @enderror">
                        <option disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category->id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </fieldset>

                {{-- Penulis --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Penulis</legend>
                    <input type="text" name="author" class="input w-full @error('author') border-error @enderror" value="{{ old('author', $book->author) }}" placeholder="Nama Penulis" />
                    @error('author') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </fieldset>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Harga --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Harga</legend>
                    <input type="number" name="price" class="input w-full @error('price') border-error @enderror" value="{{ old('price', $book->price) }}" placeholder="50000" />
                    @error('price') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </fieldset>

                {{-- Stok --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Stok</legend>
                    <input type="number" name="stock" class="input w-full @error('stock') border-error @enderror" value="{{ old('stock', $book->stock) }}" placeholder="10" />
                    @error('stock') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </fieldset>
            </div>

            {{-- Deskripsi --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Deskripsi</legend>
                <textarea name="description" class="textarea w-full h-24 @error('description') border-error @enderror" placeholder="Sinopsis buku...">{{ old('description', $book->description) }}</textarea>
                @error('description') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </fieldset>

            {{-- Cover Buku --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Cover Buku (JPG, PNG, WEBP - Max 2MB)</legend>
                <input type="file" name="image" class="file-input w-full @error('image') border-error @enderror" />
                @error('image') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </fieldset>

            <div class="pt-4">
                <button class="btn btn-info w-full" type="submit">
                    Simpan Buku Baru
                </button>
            </div>
        </form>
    </div>
@endsection