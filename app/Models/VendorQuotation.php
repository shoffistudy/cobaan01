<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_vendor_id',
        'pengajuan_pembelian_barang_detail_id',
        'unit_price',
        'total_price',
        'payment_terms',
        'notes',
        'is_selected'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'is_selected' => 'boolean',
    ];

    // Relationships
    public function rfqVendor(): BelongsTo
    {
        return $this->belongsTo(RfqVendor::class);
    }

    public function pengajuanPembelianBarangDetail(): BelongsTo
    {
        return $this->belongsTo(PengajuanPembelianBarangDetail::class);
    }

    // Accessor untuk mendapatkan data vendor melalui rfqVendor
    public function vendor(): BelongsTo
    {
        return $this->rfqVendor()->vendor();
    }

    // Accessor untuk mendapatkan data RFQ
    public function rfq()
    {
        return $this->rfqVendor->rfq;
    }

    // Helper methods
    public function canBeEdited(): bool
    {
        return $this->rfqVendor->canEditQuotation();
    }

    public function calculateTotalPrice(): void
    {
        $quantity = $this->pengajuanPembelianBarangDetail->qty;
        $this->total_price = $this->unit_price * $quantity;
    }

    public function getFormattedUnitPrice(): string
    {
        return 'Rp ' . number_format($this->unit_price, 0, ',', '.');
    }

    public function getFormattedTotalPrice(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusBadge(): string
    {
        if ($this->is_selected) {
            return '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Terpilih</span>';
        }
        
        return '<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>';
    }

    // Scope untuk quotation yang terpilih
    public function scopeSelected($query)
    {
        return $query->where('is_selected', true);
    }

    // Scope untuk quotation berdasarkan RFQ
    public function scopeForRfq($query, $rfqId)
    {
        return $query->whereHas('rfqVendor', function($q) use ($rfqId) {
            $q->where('rfq_id', $rfqId);
        });
    }

    // Scope untuk quotation berdasarkan vendor
    public function scopeForVendor($query, $vendorId)
    {
        return $query->whereHas('rfqVendor', function($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        });
    }

    // Boot method untuk auto calculate total price
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($quotation) {
            if ($quotation->isDirty('unit_price')) {
                $quotation->calculateTotalPrice();
            }
        });
    }
}