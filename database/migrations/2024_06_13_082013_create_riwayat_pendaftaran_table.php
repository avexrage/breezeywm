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
        Schema::create('riwayat_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_peserta_id');
            $table->string('ktp');
            $table->string('nama_lengkap_peserta');
            $table->string('alamat');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('statusnikah');
            $table->string('pekerjaan');
            $table->string('riwayat_penyakit');
            $table->string('hobi');
            $table->string('keahlian');
            $table->string('bahasa');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_asuransi');
            $table->string('no_asuransi');
            $table->timestamp('tanggal_riwayat');
            $table->timestamps();
            $table->foreign('data_peserta_id')->references('id')->on('data_peserta')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_pendaftaran');
    }
};