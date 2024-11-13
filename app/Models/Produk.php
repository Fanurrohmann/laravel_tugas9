<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama',
        'harga',
        'foto_produk',
        'deskripsi',
    ];

    // Relasi: Produk dimiliki oleh satu Kategori (many-to-one)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi: Produk banyak di dalam Transaksi (many-to-many)
    public function transaksi()
    {
        return $this->belongsToMany(Transaksi::class, 'produk_transaksi', 'produk_id', 'transaksi_id')
            ->withPivot('quantity'); // Jika ada kolom tambahan seperti quantity
    }
    // Produk.php
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'produk_id'); // Sesuaikan dengan nama kolom foreign key
    }
}
