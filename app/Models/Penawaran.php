<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penawaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'perbandingan_id',
        'vendor_id',
        'ketentuan_pembayaran',
        'status',
        'catatan',
        'diproses',
        'tanggal_penawaran',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'diproses' => 'boolean',
        'tanggal_penawaran' => 'datetime',
    ];

    /**
     * Get the perbandingan harga that owns the penawaran.
     */
    public function perbandinganHarga()
    {
        return $this->belongsTo(PerbandinganHarga::class, 'perbandingan_id');
    }

    /**
     * Get the vendor that owns the penawaran.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Get the items for the penawaran.
     */
    public function items()
    {
        return $this->hasMany(PenawaranItem::class, 'penawaran_id');
    }

    /**
     * Calculate total price of this penawaran
     * 
     * @return float
     */
    public function getTotalHargaAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->harga_satuan * $item->jumlah;
        });
    }
}