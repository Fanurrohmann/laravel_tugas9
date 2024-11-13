<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'), // Pastikan untuk mengenkripsi password
        ]);

        User::create([
            'name' => 'Alfa Rohman',
            'email' => 'Alfa@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
