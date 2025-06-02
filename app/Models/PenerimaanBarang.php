<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function detail()
    {
        return $this->hasMany(PenerimaanBarangDetail::class, 'penerimaan_id');
    }

    public function pemesanan()
    {
        return $this->belongsTo(PemesananBarang::class, 'pemesanan_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
