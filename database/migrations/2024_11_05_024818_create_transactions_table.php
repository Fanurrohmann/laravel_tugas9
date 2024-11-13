<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();  // ID unik dari Midtrans
            $table->string('payment_type')->nullable();
            $table->integer('gross_amount');
            $table->timestamp('transaction_time')->nullable();
            $table->enum('transaction_status', ['pending', 'settlement', 'cancel', 'expire', 'paid']); // Menambahkan 'paid' sebagai status tambahan
            $table->text('metadata')->nullable();  // Informasi tambahan dari Midtrans
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
