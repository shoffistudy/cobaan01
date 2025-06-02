<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_number',
        'pengajuan_pembelian_barang_id',
        'created_by',
        'title',
        'description',
        'deadline',
        'status',
        'sent_at',
        'closed_at'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'sent_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    // Status constants
    const STATUS_DIBUAT = 'dibuat';
    const STATUS_BERLANGSUNG = 'berlangsung';
    const STATUS_DITUTUP = 'ditutup';

    public static function getStatuses()
    {
        return [
            self::STATUS_DIBUAT => 'Dibuat',
            self::STATUS_BERLANGSUNG => 'Berlangsung',
            self::STATUS_DITUTUP => 'Ditutup'
        ];
    }

    // Relationships
    public function pengajuanPembelianBarang(): BelongsTo
    {
        return $this->belongsTo(PengajuanPembelianBarang::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rfqVendors(): HasMany
    {
        return $this->hasMany(RfqVendor::class);
    }

    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'rfq_vendors')
                   ->withPivot(['status', 'responded_at', 'reject_reason'])  
                   ->withTimestamps();
    }

    // Vendor yang sudah merespon (terima/tolak)
    public function respondedVendors(): BelongsToMany
    {
        return $this->vendors()
                   ->wherePivotIn('status', ['diterima', 'ditolak']);
    }

    // Vendor yang menerima RFQ
    public function acceptedVendors(): BelongsToMany
    {
        return $this->vendors()
                   ->wherePivot('status', 'diterima');
    }

    // Vendor yang menolak RFQ
    public function rejectedVendors(): BelongsToMany
    {
        return $this->vendors()
                   ->wherePivot('status', 'ditolak');
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === self::STATUS_BERLANGSUNG && 
               $this->deadline > now();
    }

    public function isExpired(): bool
    {
        return $this->deadline < now();
    }

    public function canBeEdited(): bool
    {
        return $this->status === self::STATUS_DIBUAT;
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_DIBUAT => 'bg-yellow-100 text-yellow-800',
            self::STATUS_BERLANGSUNG => 'bg-blue-100 text-blue-800',
            self::STATUS_DITUTUP => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Generate RFQ Number
    public static function generateRfqNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $lastRfq = self::whereYear('created_at', $year)
                      ->whereMonth('created_at', $month)
                      ->orderBy('id', 'desc')
                      ->first();
        
        $sequence = $lastRfq ? ((int) substr($lastRfq->rfq_number, -3)) + 1 : 1;
        
        return sprintf('RFQ-%s%s-%03d', $year, $month, $sequence);
    }

    // Scope untuk filter
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_BERLANGSUNG)
                    ->where('deadline', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('deadline', '<', now())
                    ->where('status', '!=', self::STATUS_DITUTUP);
    }
}