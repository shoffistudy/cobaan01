<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PerbandinganHarga extends Model
{
    use HasFactory;

    protected $table = 'perbandingan_harga';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'tanggal' => 'datetime',
        'deadline_penawaran' => 'datetime',
        'deadline_negosiasi' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPembelianBarang::class, 'pengajuan_id');
    }

    public function pengajuanDetail()
    {
        return $this->hasManyThrough(
            PengajuanPembelianBarangDetail::class,
            PengajuanPembelianBarang::class,
            'id',
            'pengajuan_id',
            'pengajuan_id',
            'id'
        );
    }

    public function perbandinganHargaVendor()
    {
        return $this->hasMany(PerbandinganHargaVendor::class, 'perbandingan_id');
    }
    
    public function pemesanan()
    {
        return $this->hasMany(PemesananBarang::class, 'perbandingan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke vendor via pivot
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'perbandingan_harga_vendor', 'perbandingan_id', 'vendor_id')
            ->withPivot([
                'status_penawaran',
                'tanggal_respon',
                // 'catatan_vendor',
                'batas_waktu_penawaran',
            ])
            // ->withTimestamps();
            ;
    }

    // Relasi ke item barang yang dibandingkan
    public function perbandinganHargaItemBarang()
    {
        return $this->hasMany(PerbandinganHargaItemBarang::class);
    }

     public function getListVendorWithHargaBarang()
    {
        $vendors = $this->perbandinganHargaVendor()->with(['vendor', 'hargaBarangIndexed'])->get();

        $list_vendor = [];

        foreach ($vendors as $vendor) {
            $nama_vendor = $vendor->vendor->nama;
            $list_vendor[$nama_vendor] = [];

            foreach ($vendor->hargaBarangIndexed as $barang) {
                $list_vendor[$nama_vendor][$barang->pengajuan_barang_detail_id] = [
                    'harga_satuan' => $barang->harga_satuan,
                    'total_harga' => $barang->harga_satuan * $barang->jumlah,
                    'pemesanan' => $barang->pemesanan,
                ];
            }
        }

        return $list_vendor;
    }

    // Ambil vendor tertentu dari pivot
    public function vendorPivot($vendorId)
    {
        return $this->vendors()->where('vendor_id', $vendorId)->first()?->pivot;
    }

    // Cek apakah penawaran masih aktif untuk vendor tertentu
    public function isPenawaranAktifUntukVendor($vendorId)
    {
        $pivot = $this->vendorPivot($vendorId);
        return $pivot && now()->lessThan($pivot->batas_waktu);
    }


    // Scope dan Helper Methods --- gak perlu sih ini --
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function isPenawaranExpired()
    {
        return $this->deadline_penawaran && Carbon::now()->isAfter($this->deadline_penawaran);
    }

    public function isNegosiasExpired()
    {
        return $this->deadline_negosiasi && Carbon::now()->isAfter($this->deadline_negosiasi);
    }

    public function getVendorByStatus($status)
    {
        return $this->perbandinganHargaVendor()->where('status_penawaran', $status)->get();
    }

    public function hasVendorResponse()
    {
        return $this->perbandinganHargaVendor()->where('status_penawaran', '!=', 'pending')->exists();
    }

    public function canStartNegosiasi()
    {
        return $this->status === 'penawaran' && 
               $this->isPenawaranExpired() && 
               $this->getVendorByStatus('diterima')->count() > 0;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'penawaran' => 'warning',
            'negosiasi' => 'info',
            'selesai' => 'success'
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}