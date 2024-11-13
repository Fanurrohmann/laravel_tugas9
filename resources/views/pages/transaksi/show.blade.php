@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Detail Transaksi #{{ $transaksi->id }}</h1>
        <table class="table">
            <tr>
                <th>Pelanggan</th>
                <td>{{ $transaksi->pelanggan->name }}</td>
            </tr>
            <tr>
                <th>Produk</th>
                <td>{{ $transaksi->produk->name }}</td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>{{ number_format($transaksi->total_harga, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td>{{ $transaksi->status_pembayaran }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $transaksi->deskripsi }}</td>
            </tr>
            <tr>
                <th>Nomor Invoice</th>
                <td>{{ $transaksi->nomor_invoice }}</td>
            </tr>
            <tr>
                <th>Tanggal Pembelian</th>
                <td>{{ $transaksi->tanggal_pembelian }}</td>
            </tr>
            <tr>
                <th>Tanggal Pembayaran</th>
                <td>{{ $transaksi->tanggal_pembayaran }}</td>
            </tr>
        </table>
        <a href="{{ route('transaksi.index') }}" class="btn btn-primary">Kembali</a>
    </div>
@endsection
