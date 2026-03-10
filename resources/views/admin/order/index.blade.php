@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <div>
            <h1 class="text-2xl font-bold">Daftar Transaksi</h1>
            <p class="text-sm text-gray-500">
                Hari ini: {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <div class="overflow-x-auto bg-base-100 rounded-box shadow-sm border border-base-200">
            <table class="table table-zebra w-full">
                <thead>
                    <tr class="bg-base-200">
                        <th>No</th>
                        <th>Kode & Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <div class="font-bold text-primary tracking-wide">{{ $order->code }}</div>
                                {{-- Memformat tanggal agar lebih user-friendly --}}
                                <div class="text-xs opacity-60">
                                    {{ \Carbon\Carbon::parse($order->date)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>
                                <div class="font-medium leading-none">{{ $order->user->name }}</div>
                                <div class="text-[10px] opacity-50 mt-1">{{ $order->user->email }}</div>
                            </td>
                            <td class="font-mono font-semibold text-base-content/80">
                                Rp{{ number_format($order->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge badge-warning badge-sm font-medium">Pending</span>
                                    @break

                                    @case('processing')
                                        <span class="badge badge-info badge-sm font-medium">Proses</span>
                                    @break

                                    @case('shipped')
                                        <span class="badge badge-accent badge-sm font-medium text-white">Dikirim</span>
                                    @break

                                    @case('completed')
                                        <span class="badge badge-success badge-sm font-medium text-white">Selesai</span>
                                    @break

                                    @default
                                        <span class="badge badge-error badge-sm font-medium text-white">Batal</span>
                                @endswitch
                            </td>
                            <td>
                                {{-- Gunakan flex agar tombol rapi --}}
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-ghost btn-xs text-info hover:bg-info/10">
                                        detail
                                    </a>

                                    @if ($order->status == 'processing')
                                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="btn btn-xs btn-primary shadow-sm">
                                            tambah resi
                                        </a>
                                    @endif

                                    {{-- Saran: Tambahkan tombol 'Selesaikan' jika status sudah Shipped --}}
                                    @if ($order->status == 'shipped')
                                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit"
                                                class="btn btn-xs btn-success text-white">Selesai</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-400 italic">
                                    Belum ada transaksi masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
