<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // ID pengguna yang membuat order
        'total_harga',  // Total harga order
        'status',       // Status order (pending, completed, dll.)
    ];

    // Relasi dengan pengguna
    public function user()
    {
        return $this->belongsTo(User::class); // Satu order dimiliki oleh satu pengguna
    }

    // Relasi dengan transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class); // Satu order bisa memiliki banyak transaksi
    }
}
