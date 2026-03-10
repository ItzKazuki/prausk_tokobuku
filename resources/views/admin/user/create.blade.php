@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-base-100 shadow-xl rounded-box">
    <h2 class="text-2xl font-bold mb-6">Tambah Pengguna Baru</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nama Lengkap --}}
        <div class="form-control">
            <label class="label"><span class="label-text">Nama Lengkap</span></label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="input input-bordered @error('name') input-error @enderror" 
                   placeholder="John Doe" required />
            @error('name') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div class="form-control">
            <label class="label"><span class="label-text">Alamat Email</span></label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   class="input input-bordered @error('email') input-error @enderror" 
                   placeholder="johndoe@example.com" required />
            @error('email') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Password --}}
            <div class="form-control">
                <label class="label"><span class="label-text">Password</span></label>
                <input type="password" name="password" 
                       class="input input-bordered @error('password') input-error @enderror" 
                       placeholder="••••••••" required />
                @error('password') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-control">
                <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                <input type="password" name="password_confirmation" 
                       class="input input-bordered" 
                       placeholder="••••••••" required />
            </div>
        </div>

        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
        </div>
    </form>
</div>
@endsection