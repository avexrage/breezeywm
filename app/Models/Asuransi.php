<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_asuransi', 'no_asuransi'];
    protected $table = 'asuransi';
    public $timestamps = false;

    public function dataPeserta()
    {
        return $this->belongsTo(DataPeserta::class, 'asuransi_id', 'id');
    }
}