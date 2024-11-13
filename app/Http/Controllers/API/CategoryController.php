<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Kategori; // Menggunakan model Kategori

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::all();
        $data = [
            "message" => "Data Kategori Berhasil diambil",
            "data" => $categories
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "nama" => ["required"],
                "slug" => ["required"]
            ], [
                "nama.required" => "Nama kategori harus diisi",
                "slug.required" => "Slug kategori harus diisi"
            ]);

            Kategori::create([
                "nama" => $request->nama,
                "slug" => $request->slug
            ]);

            return response()->json([
                "message" => "Data kategori berhasil ditambahkan",
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Data kategori gagal ditambahkan",
                "error" => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                "nama" => ["required"],
                "slug" => ["required"]
            ], [
                "nama.required" => "Nama kategori harus diisi",
                "slug.required" => "Slug kategori harus diisi"
            ]);

            Kategori::where("id", $id)->update([
                "nama" => $request->nama,
                "slug" => $request->slug
            ]);

            return response()->json([
                "message" => "Data kategori berhasil diubah",
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Data kategori gagal diubah",
                "error" => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return response()->json([
                "message" => "Data kategori berhasil dihapus",
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Data kategori gagal dihapus",
                "error" => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
