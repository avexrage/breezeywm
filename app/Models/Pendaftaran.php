<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $fillable = [
        'check_in',
        'check_out',
        'metode_pembayaran',
        'program_id',
        'data_peserta_id',
        'user_id'
    ];

    public function program(){
        return $this->belongsToMany(Program::class, 'detail_pendaftaran', 'pendaftaran_id', 'program_id',)
                    ->withPivot('tanggal', 'tipe', 'harga', 'durasi')
                    ->withTimestamps();
    }

    public function peserta(){
        return $this->belongsTo(Peserta::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transaksi(){
        return $this->hasOne(Transaksi::class);
    }
}
