<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video';
    public $timestamps = false;
    protected $fillable = [
        'nama_file',
        'tanggal_upload',
        'ukuran_file',
        'peserta_id'
    ];

    public function peserta(){
        return $this->belongsTo(Peserta::class);
    }
}
