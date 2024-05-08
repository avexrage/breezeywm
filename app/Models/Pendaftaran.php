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
        'user_id'
    ];

    public function program(){
        return $this->belongsTo(Program::class, 'program_id', 'id_program');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dataPeserta(){
        return $this->hasOne(DataPeserta::class);
    }

    public function transaksi(){
        return $this->hasOne(Transaksi::class);
    }
}
