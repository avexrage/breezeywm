<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = ['ktp', 'nama_lengkap_peserta', 'alamat', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
    'agama', 'statusnikah', 'pekerjaan', 'riwayat_penyakit', 'hobi', 'keahlian', 'bahasa', 'user_id'];

    protected $table = 'peserta';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function asuransi(){
        return $this->hasOne(Asuransi::class);
    }

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }
    
    public function video(){
        return $this->hasOne(Video::class);
    }
}