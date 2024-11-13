<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')
                ->constrained('pelanggan')
                ->onDelete('cascade'); // Menghapus transaksi jika pelanggan dihapus
            $table->decimal('total_harga', 15, 2);
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->onDelete('cascade'); // Menghapus transaksi jika produk dihapus
            $table->text('deskripsi')->nullable();
            $table->string('nomor_invoice')->unique(); // Menambahkan indeks unik
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed']);
            $table->timestamp('tanggal_pembelian');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
