<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';
    protected $primaryKey = 'id_program';
    protected $fillable = [
        'id_program',
        'nama_program',
        'tipe',
        'harga',
    ];

    public function pendaftaran(){
        return $this->belongsToMany(Pendaftaran::class, 'detail_pendaftaran', 'program_id', 'pendaftaran_id')
                    ->withPivot('tanggal', 'tipe', 'harga', 'durasi')
                    ->withTimestamps();
    }
}