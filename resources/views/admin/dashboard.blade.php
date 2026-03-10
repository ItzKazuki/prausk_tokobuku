@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}</h1>
            <p>selamat datang di dashboard admin kabuku, platform jual beli buku yang terpercaya di Indonesia!</p>
        </div>
    </div>
@endsection
