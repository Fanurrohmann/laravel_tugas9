<?php

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        return [
            'pelanggan_id' => Pelanggan::inRandomOrder()->first()->id,
            'produk_id' => Produk::inRandomOrder()->first()->id,
            'total_harga' => $this->faker->randomFloat(2, 10000, 1000000),
            'deskripsi' => $this->faker->sentence,
            'nomor_invoice' => $this->faker->unique()->word,
            'status_pembayaran' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'tanggal_pembelian' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'tanggal_pembayaran' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
