<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranVendor extends Model
{
    use HasFactory;

    protected $table = 'penawaran_vendor';
    protected $guarded = ['id'];
    public $timestamps = false;

    // Define status constants for better code readability
    const STATUS_INVITED = 'invited';
    const STATUS_SEEN = 'seen';
    const STATUS_RESPONDED = 'responded';
    const STATUS_SELECTED = 'selected';
    const STATUS_REJECTED = 'rejected';

    // Get the related penawaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id');
    }

    // Get the related vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    // Get all items for this vendor's quotation
    public function items()
    {
        return $this->hasMany(PenawaranItem::class, 'penawaran_vendor_id');
    }

    // Calculate total quotation value
    public function getTotalQuotationAttribute()
    {
        return $this->items->sum('total_harga');
    }

    // Check if all items have prices
    public function allItemsHavePrices()
    {
        return $this->items()
            ->whereNotNull('harga_satuan')
            ->count() === $this->items()->count();
    }

    // Check if status can be changed to responded
    public function canMarkAsResponded()
    {
        return $this->status === self::STATUS_INVITED || $this->status === self::STATUS_SEEN;
    }
}