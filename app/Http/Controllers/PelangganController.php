<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pages.pelanggan.pelanggan', compact('pelanggan'));
    }

    public function create()
    {
        return view('pages.pelanggan.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email',
            'nomor_hp' => 'required',
            'alamat' => 'required',
        ]);

        Pelanggan::create($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pages.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email',
            'nomor_hp' => 'required',
            'alamat' => 'required',
        ]);

        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
    // Menampilkan data pelanggan dan jumlah transaksi
    public function getCustomerTransactionCount()
    {
        $pelanggan = Pelanggan::withCount('transaksis') // Pastikan relasi ini ada
            ->select('id as id_pelanggan', 'nama_lengkap as nama', 'nomor_hp as nomor_telepon', 'alamat')
            ->get();

        return response()->json($pelanggan);
    }
}
