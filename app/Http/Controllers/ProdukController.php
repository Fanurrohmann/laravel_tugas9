<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('pages.produk.produk', compact('produk'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $kategori = Kategori::all();
        return view('pages.produk.tambah', compact('kategori'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'nullable',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
        } else {
            $filename = null;
        }

        // Simpan data produk
        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'foto_produk' => $filename,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan form edit produk
    public function edit(Produk $produk)
    {
        $kategori = Kategori::all();
        return view('pages.produk.edit', compact('produk', 'kategori'));
    }

    // Memperbarui produk
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'nullable',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Cek jika ada file gambar yang diupload
        if ($request->hasFile('foto_produk')) {
            // Hapus gambar lama jika ada
            if ($produk->foto_produk && File::exists(public_path('uploads/' . $produk->foto_produk))) {
                File::delete(public_path('uploads/' . $produk->foto_produk));
            }

            // Simpan gambar baru
            $file = $request->file('foto_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
        } else {
            // Tetap gunakan gambar lama jika tidak ada yang diunggah
            $filename = $produk->foto_produk;
        }

        // Update produk
        $produk->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'foto_produk' => $filename,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    // Menghapus produk
    public function destroy(Produk $produk)
    {
        // Hapus gambar jika ada
        if ($produk->foto_produk && File::exists(public_path('uploads/' . $produk->foto_produk))) {
            File::delete(public_path('uploads/' . $produk->foto_produk));
        }

        // Hapus produk
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
    // Menampilkan daftar produk dengan kategori
    public function getProducts()
    {
        $produk = Produk::with('kategori:id,nama')->select('id', 'nama', 'deskripsi', 'harga', 'kategori_id')->get();
        return response()->json($produk);
    }
    // Menampilkan data produk dan jumlah transaksi
    public function getProductTransactionCount()
    {
        $produk = Produk::select('id', 'nama', 'harga', 'kategori_id')
            ->withCount('transaksis') // Pastikan relasi ini ada
            ->get();

        return response()->json($produk);
    }
}
