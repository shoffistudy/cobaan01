<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbandinganHargaItemBarang extends Model
{
    use HasFactory;

    protected $table = 'perbandingan_harga_item_barang';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function pengajuanDetail()
    {
        return $this->belongsTo(PengajuanPembelianBarangDetail::class, 'pengajuan_barang_detail_id');
    }

    public function perbandinganVendor()
    {
        return $this->belongsTo(PerbandinganHargaVendor::class, 'perbandingan_vendor_id');
    }
}
