@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        @if (session('success'))
            <div role="alert" class="alert alert-success shadow-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error shadow-sm mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Manajemen Buku</h1>

            <div class="flex flex-row gap-4">
                <form method="get">
                    <input type="text" name="search" placeholder="Cari buku, ex: nama, author" class="input" />
                </form>

                <a class="btn btn-info" href="{{ route('admin.books.create') }}">Buat Buku Baru</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td><span class="badge badge-success bagde-sm">{{ $book->category->name }}</span></td>
                            <td>Rp{{ number_format($book->price, 0, ',', '.') }}</td>
                            <td>{{ $book->stock }}</td>
                            <td class="space-y-2">
                                <a href="{{ route('admin.books.edit', ['book' => $book->id]) }}"
                                    class="btn btn-xs btn-warning">update</a>
                                <form action="{{ route('admin.books.destroy', ['book' => $book->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-xs btn-error">delete</button>

                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center italic text-gray-500 py-4">
                                Data Buku Tidak Ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
