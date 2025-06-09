<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganHargaVendor extends Model
{
    // 
    use HasFactory;

    protected $table = 'perbandingan_harga_vendor';
    protected $guarded = ['id'];
    protected $casts = [
        'batas_waktu_penawaran' => 'datetime',
    ];
    public $timestamps = false;

    public function perbandinganHarga()
    {
        return $this->belongsTo(PerbandinganHarga::class, 'perbandingan_id');
    }

    public function perbandinganHargaItemBarang()
    {
        return $this->hasMany(PerbandinganHargaItemBarang::class, 'perbandingan_vendor_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function hargaBarangIndexed()
    {
        return $this->hasMany(PerbandinganHargaItemBarang::class, 'perbandingan_vendor_id')
                    ->with('pengajuanDetail');
    }

    public function isBerakhir()
    {
        return $this->batas_waktu_penawaran && now()->gt($this->batas_waktu_penawaran);
    }


}

