<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranItem extends Model
{
    use HasFactory;

    protected $table = 'penawaran_item';
    protected $guarded = ['id'];
    public $timestamps = false;

    // Get the related penawaran vendor
    public function penawaranVendor()
    {
        return $this->belongsTo(PenawaranVendor::class, 'penawaran_vendor_id');
    }

    // Get the related pengajuan detail
    public function pengajuanDetail()
    {
        return $this->belongsTo(PengajuanPembelianBarangDetail::class, 'pengajuan_detail_id');
    }

    // Calculate total price
    public function calculateTotalPrice()
    {
        if ($this->harga_satuan !== null && $this->jumlah !== null) {
            $this->total_harga = $this->harga_satuan * $this->jumlah;
            return $this->total_harga;
        }
        
        return 0;
    }
}