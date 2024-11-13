<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1,  // Misalkan ini ID pengguna yang valid
            'total_harga' => 100000,
            'status' => 'completed',
        ]);

        Order::create([
            'user_id' => 1,
            'total_harga' => 200000,
            'status' => 'pending',
        ]);
    }
}
