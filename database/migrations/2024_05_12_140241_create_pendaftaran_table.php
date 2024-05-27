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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->date('check_in')->default(null); 
            $table->date('check_out')->default(null); 
            $table->enum('metode_pembayaran',['Tunai', 'Transfer BRI']);
            $table->enum('status_pendaftaran',['Baru', 'Ditolak', 'Diterima', 'Menunggu Jadwal', 'Dibatalkan']);
            $table->foreignId('data_peserta_id')->constrained('data_peserta')->onDelete('cascade');
            $table->string('program_id', 5);
            $table->foreign('program_id')->references('id_program')->on('program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
};