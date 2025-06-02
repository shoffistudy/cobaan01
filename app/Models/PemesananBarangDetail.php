<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananBarangDetail extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_barang_detail';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function pemesanan()
    {
        return $this->belongsTo(PemesananBarang::class, 'pemesanan_id');
    }

    public function perbandinganHargaItemBarang()
    {
        return $this->belongsTo(PerbandinganHargaItemBarang::class, 'perbandingan_barang_id');
    }
}
