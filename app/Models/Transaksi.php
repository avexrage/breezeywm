<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    public $timestamps = false;
    protected $fillable = [
        'tanggal_transaksi',
        'status_pembayaran',
        'total_harga',
        'pendaftaran_id'
    ];
    
    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class);
    }
    
    public function buktiTransaksi(){
        return $this->hasOne(BuktiTransaksi::class);
    }
}
