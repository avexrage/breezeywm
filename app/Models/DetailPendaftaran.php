<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'detail_pendaftaran';
    protected $fillable = [
        'pendaftaran_id',
        'program_id',
        'tanggal',
        'tipe',
        'harga',
        'durasi'
    ];

}
