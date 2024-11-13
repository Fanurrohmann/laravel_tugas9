<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produks')->insert([
            [
                'nama_produk' => 'Smartphone',
                'kategori_id' => 1, // ID kategori Elektronik
                'harga' => 2000000,
                'stok' => 50,
            ],
            [
                'nama_produk' => 'Kaos',
                'kategori_id' => 2, // ID kategori Pakaian
                'harga' => 75000,
                'stok' => 100,
            ],
            // Tambahkan produk lain sesuai kebutuhan
        ]);
    }
}
