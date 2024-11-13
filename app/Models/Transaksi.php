<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory; // Menambahkan trait HasFactory

    protected $table = 'transaksi'; // Nama tabel di database

    protected $fillable = [
        'pelanggan_id',
        'produk_id',
        'total_harga',
        'deskripsi',
        'nomor_invoice',
        'status_pembayaran',
        'tanggal_pembelian',
        'tanggal_pembayaran',
    ];

    // Relasi ke model Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke model Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Menambahkan accessor untuk format total_harga
    public function getFormattedTotalHargaAttribute()
    {
        return number_format($this->total_harga, 2, ',', '.');
    }

    // Menambahkan mutator untuk menyimpan total_harga dalam format yang benar
    public function setTotalHargaAttribute($value)
    {
        $this->attributes['total_harga'] = str_replace('.', '', $value); // Menghapus titik
        $this->attributes['total_harga'] = str_replace(',', '.', $this->attributes['total_harga']); // Mengubah koma menjadi titik
    }
}
