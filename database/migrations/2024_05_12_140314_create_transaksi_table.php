<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_transaksi')->nullable();
            $table->enum('status_pembayaran',['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->integer('total_harga');
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->timestamps(); // Tambahkan kolom timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};