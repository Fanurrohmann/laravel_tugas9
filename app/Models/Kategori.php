<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Menentukan nama tabel jika berbeda dari penamaan default
    protected $table = 'kategori';

    // Atribut yang bisa diisi
    protected $fillable = [
        'nama',
        'keterangan',
    ];

    // Relasi: Kategori memiliki banyak Produk (one-to-many)
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
    // Kategori.php
    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
