<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; //untuk login
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Vendor extends Authenticatable
{
    use HasRoles;

    public $timestamps = false;
    
    protected $table = 'vendor';
    //protected $guard_name = 'web';
    protected $guarded = ['id'];
    
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Tambahkan di dalam class Vendor:

    public function rfqs()
    {
        return $this->belongsToMany(Rfq::class, 'rfq_vendors')
                ->withPivot(['status', 'responded_at', 'reject_reason'])
                ->withTimestamps();
    }

    public function rfqVendors()
    {
        return $this->hasMany(RfqVendor::class);
    }

    public function quotations()
    {
        return $this->hasMany(VendorQuotation::class, 'rfq_vendor_id', 'id')
                ->join('rfq_vendors', 'vendor_quotations.rfq_vendor_id', '=', 'rfq_vendors.id')
                ->where('rfq_vendors.vendor_id', $this->id);
    }

    // Method helper untuk vendor
    public function getActiveRfqs()
    {
        return $this->rfqVendors()
                ->with('rfq')
                ->whereHas('rfq', function($q) {
                    $q->where('status', Rfq::STATUS_BERLANGSUNG)
                        ->where('deadline', '>', now());
                });
    }

    public function getPendingRfqs()
    {
        return $this->rfqVendors()
                ->with('rfq')
                ->where('status', RfqVendor::STATUS_DITAWARKAN)
                ->whereHas('rfq', function($q) {
                    $q->where('status', Rfq::STATUS_BERLANGSUNG)
                        ->where('deadline', '>', now());
                });
    }
}