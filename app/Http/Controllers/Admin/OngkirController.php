<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    public function cekOngkir(Request $request)
    {
        // Ambil data dari frontend
        $origin = $request->input('origin');       // ID kota asal
        $destination = $request->input('destination'); // ID kota tujuan (kode pos atau ID kota dari Raja Ongkir)
        $weight = $request->input('weight');       // Berat paket dalam gram
        $courier = $request->input('courier');     // Kurir yang dipilih (jne, pos, tiki, dll)

        try {
            // Panggil API Raja Ongkir dengan data dinamis
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY') // API key dari file .env yang sudah disesuaikan
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ]);

            // Cek jika response sukses
            if ($response->successful()) {
                $result = $response->json();

                // Ambil data ongkir dan estimasi
                $costs = $result['rajaongkir']['results'][0]['costs'];

                return response()->json([
                    'status' => 'success',
                    'costs' => $costs,
                ]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Gagal mendapatkan data ongkir'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghubungi API Raja Ongkir'], 500);
        }
    }
}
