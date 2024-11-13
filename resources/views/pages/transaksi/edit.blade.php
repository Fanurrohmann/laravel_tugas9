@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Edit Transaksi</h1>
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="pelanggan_id" class="form-label">Pelanggan</label>
                <select name="pelanggan_id" id="pelanggan_id" class="form-select" required>
                    @foreach ($pelanggan as $pelanggan)
                        <option value="{{ $pelanggan->id }}"
                            {{ $pelanggan->id == $transaksi->pelanggan_id ? 'selected' : '' }}>
                            {{ $pelanggan->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="produk_id" class="form-label">Produk</label>
                <select name="produk_id" id="produk_id" class="form-select" required>
                    @foreach ($produk as $produk)
                        <option value="{{ $produk->id }}" {{ $produk->id == $transaksi->produk_id ? 'selected' : '' }}>
                            {{ $produk->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="text" name="total_harga" id="total_harga" class="form-control"
                    value="{{ $transaksi->total_harga }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control">{{ $transaksi->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label for="nomor_invoice" class="form-label">Nomor Invoice</label>
                <input type="text" name="nomor_invoice" id="nomor_invoice" class="form-control"
                    value="{{ $transaksi->nomor_invoice }}" required>
            </div>
            <div class="mb-3">
                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                    <option value="pending" {{ $transaksi->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="paid" {{ $transaksi->status_pembayaran == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $transaksi->status_pembayaran == 'failed' ? 'selected' : '' }}>Failed
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control"
                    value="{{ $transaksi->tanggal_pembelian }}" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control"
                    value="{{ $transaksi->tanggal_pembayaran }}">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
