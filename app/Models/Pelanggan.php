<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'email',
        'nomor_hp',
        'alamat',
        'foto_profil',
    ];

    // Relasi: Pelanggan memiliki banyak Transaksi (one-to-many)
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }
    // Pelanggan.php
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id'); // Sesuaikan dengan nama kolom foreign key
    }
}
