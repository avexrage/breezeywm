<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_peserta', function (Blueprint $table) {
            $table->id();
            $table->string('ktp', 16);
            $table->string('nama_lengkap_peserta', 50);
            $table->text('alamat');
            $table->string('tempat_lahir', 30);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin',['Laki-laki', 'Perempuan']);
            $table->enum('agama',['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']);
            $table->enum('statusnikah',['Belum Kawin', 'Kawin', 'Cerai Mati', 'Cerai Hidup']);
            $table->string('pekerjaan', 30);
            $table->string('riwayat_penyakit', 50);
            $table->string('hobi', 30);
            $table->string('keahlian', 30);
            $table->string('bahasa', 30);
            $table->enum('status_peserta',['Aktif','Tidak Aktif'])->default('Tidak Aktif');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->timestamps();
        });

    }
    public function down()
        {
            Schema::dropIfExists('data_peserta');
        }
};