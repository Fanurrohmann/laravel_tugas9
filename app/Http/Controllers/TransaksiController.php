<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua transaksi dengan relasi pelanggan dan produk
        $transaksi = Transaksi::with(['pelanggan', 'produk'])->get();
        return view('pages.transaksi.transaksi', compact('transaksi')); // Menyesuaikan nama view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan::all(); // Ambil semua data pelanggan
        $produk = Produk::all(); // Ambil semua data produk
        return view('pages.transaksi.create', compact('pelanggan', 'produk'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $this->validateRequest($request);

        // Simpan transaksi baru ke database
        Transaksi::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        // Menampilkan detail transaksi
        return view('pages.transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        // Mengambil pelanggan dan produk untuk dropdown pilihan di form edit
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        return view('pages.transaksi.edit', compact('transaksi', 'pelanggan', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        // Validasi data update
        $validated = $this->validateRequest($request, $transaksi->id);

        // Update transaksi
        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /// Validasi request untuk store dan update.
    protected function validateRequest(Request $request, $transaksiId = null)
    {
        return $request->validate([
            'pelanggan_id' => 'required|integer|exists:pelanggan,id',
            'produk_id' => 'required|integer|exists:produk,id',
            'total_harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'nomor_invoice' => [
                'required',
                'string',
                'unique:transaksi,nomor_invoice' . ($transaksiId ? ',' . $transaksiId : ''),
            ],
            'status_pembayaran' => 'required|in:pending,paid,failed',
            'tanggal_pembelian' => 'required|date',
            'tanggal_pembayaran' => 'nullable|date|after_or_equal:tanggal_pembelian',
        ]);
    }
}
