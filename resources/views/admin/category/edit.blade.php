@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h1 class="text-2xl font-bold">Edit Kategori</h1>

        <form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="post" class="space-y-2">
            @csrf
            @method('PUT')
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Kategori</legend>
                <input type="text" name="name" class="input" placeholder="example: Novel" value="{{ $category->name }}" />
            </fieldset>

            <button class="btn btn-warning" type="submit">
                Ubah Kategori
            </button>
        </form>
    </div>
@endsection
