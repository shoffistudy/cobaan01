<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PengajuanPembelianBarangDetail extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembelian_barang_detail';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPembelianBarang::class, 'pengajuan_id');
    }

    public function pemesanan()
    {
        return $this->pengajuan?->pemesanan; // jika pengajuan punya relasi ke pemesanan
    }

    public function penerimaan()
    {
        return $this->pengajuan?->penerimaan; // jika pengajuan punya relasi ke penerimaan
    }

    // Tambahkan di dalam class PengajuanPembelianBarangDetail:

    public function vendorQuotations()
    {
        return $this->hasMany(VendorQuotation::class);
    }

    // Method untuk mendapatkan quotation terpilih
    public function selectedQuotation()
    {
        return $this->vendorQuotations()->where('is_selected', true)->first();
    }

    // Method untuk mendapatkan semua quotation untuk item ini
    public function getAllQuotations()
    {
        return $this->vendorQuotations()
                    ->with(['rfqVendor.vendor'])
                    ->orderBy('unit_price', 'asc');
    }

}
