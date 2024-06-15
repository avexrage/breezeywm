<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_asuransi', 'no_asuransi', 'peserta_id'];
    protected $table = 'asuransi';
    public $timestamps = false;

    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }
}