<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    // Mengambil semua produk
    public function index()
    {
        $produk = Produk::with('kategori')->get(); // Mengambil produk dengan kategori
        return response()->json([
            "message" => "Data produk berhasil diambil",
            "data" => $produk
        ], Response::HTTP_OK);
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|string', // Validasi tergantung format foto yang digunakan
            'deskripsi' => 'nullable|string',
        ]);

        $produk = Produk::create($request->all());
        return response()->json([
            "message" => "Data produk berhasil ditambahkan",
            "data" => $produk
        ], Response::HTTP_CREATED);
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $produk = Produk::with('kategori')->find($id); // Menampilkan produk beserta kategori
        if ($produk) {
            return response()->json([
                "message" => "Detail produk ditemukan",
                "data" => $produk
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Produk tidak ditemukan"
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $produk = Produk::find($id);
        if ($produk) {
            $produk->update($request->all());
            return response()->json([
                "message" => "Data produk berhasil diubah",
                "data" => $produk
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Produk tidak ditemukan"
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            $produk->delete();
            return response()->json([
                "message" => "Data produk berhasil dihapus"
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                "message" => "Produk tidak ditemukan"
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
