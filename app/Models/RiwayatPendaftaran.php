<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendaftaran';
    protected $fillable = [
        'data_peserta_id',
        'ktp',
        'nama_lengkap_peserta',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'statusnikah',
        'pekerjaan',
        'riwayat_penyakit',
        'hobi',
        'keahlian',
        'bahasa',
        'user_id',
        'nama_asuransi',
        'no_asuransi',
        'tanggal_riwayat'
    ];

    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class);
    }

    public function dataPeserta()
    {
        return $this->belongsTo(DataPeserta::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
