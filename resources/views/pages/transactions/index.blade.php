@extends('layouts.master')

@section('content')
    <div class="container">
        <h2 class="text-center my-4">Daftar Transaksi</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Customer</th>
                    <th>Detail Produk</th>
                    <th>Total Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Tanggal Pembelian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->customer_name }}</td>
                        <td>{{ $transaction->product_details }}</td>
                        <td>{{ number_format($transaction->total_payment, 0, ',', '.') }}</td>
                        <td>{{ $transaction->order_status }}</td>
                        <td>{{ $transaction->purchase_date }}</td>
                        <td>
                            <!-- Tampilkan tombol tindakan seperti Bayar atau Lihat Detail -->
                            @if ($transaction->order_status === 'pending')
                                <button class="btn btn-success">Bayar</button>
                            @else
                                <button class="btn btn-primary">Lihat Detail</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
