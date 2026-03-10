@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Pembayaran Order #{{ $order->code }}</h3>
        <p>Total Bayar: <strong>Rp {{ number_format($order->amount) }}</strong></p>

        <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        const payButton = document.querySelector('#pay-button');

        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result) {
                    // UI update: Arahkan ke halaman riwayat pesanan
                    window.location.href = "{{ route('user.order.index') }}";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function() {
                    alert('Anda menutup popup sebelum membayar');
                }
            });
        });
    </script>
@endsection
