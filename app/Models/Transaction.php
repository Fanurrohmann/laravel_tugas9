<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_type',
        'gross_amount',
        'transaction_time',
        'transaction_status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',            // Menyimpan metadata dalam format JSON
        'transaction_time' => 'datetime', // Memastikan transaction_time di-cast ke objek datetime
    ];
}
