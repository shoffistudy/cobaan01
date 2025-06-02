<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RfqVendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_id',
        'vendor_id',
        'status',
        'responded_at',
        'reject_reason'
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    // Status constants
    const STATUS_DITAWARKAN = 'ditawarkan';
    const STATUS_DITERIMA = 'diterima';
    const STATUS_DITOLAK = 'ditolak';

    public static function getStatuses()
    {
        return [
            self::STATUS_DITAWARKAN => 'Ditawarkan',
            self::STATUS_DITERIMA => 'Diterima',
            self::STATUS_DITOLAK => 'Ditolak'
        ];
    }

    // Relationships
    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(VendorQuotation::class);
    }

    // Helper methods
    public function canSubmitQuotation(): bool
    {
        return $this->status === self::STATUS_DITERIMA && 
               $this->rfq->isActive();
    }

    public function hasSubmittedQuotation(): bool
    {
        return $this->quotations()->exists();
    }

    public function canEditQuotation(): bool
    {
        return $this->canSubmitQuotation() && 
               $this->hasSubmittedQuotation();
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_DITAWARKAN => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DITERIMA => 'bg-green-100 text-green-800',
            self::STATUS_DITOLAK => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getTotalQuotationAmount(): float
    {
        return $this->quotations()->sum('total_price');
    }

    // Scope untuk filter berdasarkan vendor (untuk vendor yang login)
    public function scopeForVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    // Scope untuk RFQ yang masih aktif
    public function scopeActiveRfq($query)
    {
        return $query->whereHas('rfq', function($q) {
            $q->where('status', Rfq::STATUS_BERLANGSUNG)
              ->where('deadline', '>', now());
        });
    }
}