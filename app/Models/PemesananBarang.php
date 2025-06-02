<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananBarang extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_barang';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function detail()
    {
        return $this->hasMany(PemesananBarangDetail::class, 'pemesanan_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function perbandingan()
    {
        return $this->belongsTo(PerbandinganHarga::class, 'perbandingan_id');
    }

    public function penerimaan()
    {
        return $this->hasMany(PenerimaanBarang::class, 'pemesanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
