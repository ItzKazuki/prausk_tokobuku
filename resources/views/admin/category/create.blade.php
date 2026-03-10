@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h1 class="text-2xl font-bold">Buat Kategori Baru</h1>

        <form action="{{ route('admin.categories.store') }}" method="post" class="space-y-2">
            @csrf
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Kategori</legend>
                <input type="text" name="name" class="input" placeholder="example: Novel" />
            </fieldset>

            <button class="btn btn-info" type="submit">
                Tambah Kategori
            </button>
        </form>
    </div>
@endsection
