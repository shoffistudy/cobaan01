<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PengajuanPembelianBarang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembelian_barang';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function detail()
    {
        return $this->hasMany(PengajuanPembelianBarangDetail::class, 'pengajuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function perbandingan()
    {
        return $this->hasOne(PerbandinganHarga::class, 'pengajuan_id');
    }

    public function pemesanan()
    {
        return $this->hasOne(PemesananBarang::class, 'pengajuan_id');
    }

    // Relasi ke detail barang (RiwayatBarang)
    public function riwayatBarang()
    {
        return $this->hasMany(RiwayatBarang::class, 'pengajuan_id'); // Relasi ke RiwayatBarang
    }

    // Tambahkan di dalam class PengajuanPembelianBarang:

    public function rfqs()
    {
        return $this->hasMany(Rfq::class);
    }

    // Method helper untuk cek apakah sudah ada RFQ
    public function hasActiveRfq(): bool
    {
        return $this->rfqs()
                    ->whereIn('status', [Rfq::STATUS_DIBUAT, Rfq::STATUS_BERLANGSUNG])
                    ->exists();
    }

}
