<?php

namespace App\Http\Controllers;

use App\Models\Image;  // Import model Image
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // Metode untuk menyimpan gambar yang diupload
    public function store(Request $request)
    {
        // Validasi form upload gambar
        $request->validate([
            'filename' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan file gambar
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        // Simpan data gambar ke database
        Image::create([
            'filename' => $request->filename,
            'description' => $request->description,
            'image_path' => $imageName,
        ]);

        // Redirect ke halaman galeri dengan pesan sukses
        return redirect()->route('images.index')->with('success', 'Image uploaded successfully.');
    }

    // Metode untuk menampilkan form upload gambar
    public function create()
    {
        return view('upload');
    }

    // menampilkan gambar di galeri
    public function index()
    {
        $images = Image::all();
        return view('gallery', compact('images'));
    }
}
