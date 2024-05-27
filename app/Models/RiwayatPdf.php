<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPdf extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pdf';
    protected $fillable = [
        'pendaftaran_id'
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class);
    }
}
