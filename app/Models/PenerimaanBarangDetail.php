<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarangDetail extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang_detail';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function penerimaan()
    {
        return $this->belongsTo(PenerimaanBarang::class, 'penerimaan_id');
    }
}
