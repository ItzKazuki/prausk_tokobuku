@extends('layouts.app')

@section('content')
    <div class="space-y-4">
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

        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Manajemen Pengguna</h1>

            <div class="flex flex-row gap-4">
                <form method="get">
                    <input type="text" name="search" placeholder="Cari pengguna, ex: nama, email" class="input" />
                </form>

                <a class="btn btn-info" href="{{ route('admin.users.create') }}">Buat Pengguna Baru</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Total Transaction</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="{{ $user->avatar_url }}" alt="Avatar Tailwind CSS Component" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $user->name }}</div>
                                        <div class="text-sm opacity-50">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-success badge-sm">{{ $user->role }}</span>
                            </td>
                            <td>{{ $user->orders()->count() }}</td>
                            <th class="space-y-2">
                                <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}"
                                    class="btn btn-warning btn-xs">update</a>
                                <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-error btn-xs">delete</button>
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
