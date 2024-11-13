@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Detail Transaksi</h1>
        <p>Produk: {{ $transaction->product->name }}</p>
        <p>Ongkir: Rp {{ number_format($transaction->ongkir, 0, ',', '.') }}</p>
        <p>Total Harga: Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>

        @if ($transaction->status == 'pending')
            <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
        @elseif($transaction->status == 'paid')
            <p>Status Pembayaran: Lunas</p>
        @else
            <p>Status Pembayaran: Gagal</p>
        @endif
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // Menggunakan Snap Token yang diterima dari controller
            snap.pay("{{ $snapToken }}", {
                onSuccess: function(result) {
                    alert('Pembayaran Berhasil!');
                    // Arahkan pengguna setelah pembayaran sukses
                    window.location.href =
                    '/transactions/{{ $transaction->id }}'; // Redirect ke halaman detail transaksi
                },
                onPending: function(result) {
                    alert('Pembayaran Pending!');
                },
                onError: function(result) {
                    alert('Terjadi Kesalahan pada Pembayaran!');
                }
            });
        }
    </script>
@endsection
