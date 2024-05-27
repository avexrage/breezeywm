<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    public $timestamps = false;
    protected $fillable = [
        'check_in',
        'check_out',
        'metode_pembayaran',
        'program_id',
        'data_peserta_id'
    ];

    public function program(){
        return $this->belongsTo(Program::class, 'program_id', 'id_program');
    }

    public function dataPeserta(){
        return $this->belongsTo(DataPeserta::class);
    }

    public function transaksi(){
        return $this->hasOne(Transaksi::class);
    }

    public function riywayatPdf(){
        return $this->hasOne(RiwayatPdf::class);
    }
}
