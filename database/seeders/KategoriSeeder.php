<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Barang elektronik'],
            ['nama_kategori' => 'Pakaian', 'deskripsi' => 'Aneka pakaian'],
        ]);

    }
}
