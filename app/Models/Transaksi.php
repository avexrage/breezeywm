<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = [
        'ktp',
        'email',
        'password',
        'nama',
        'no_hp',
        'alamat',
        'pekerjaan',
        'role',
        'email_verified_at'
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
    }
    
}
