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

    // Scope dan Helper Methods
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