<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Vendor extends Model
{
    use HasFactory, Notifiable, HasRoles;

    public $timestamps = false;

    protected $table = 'vendor';

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard_name = 'web'; // default guard untuk spatie permission

    /**
     * Perbandingan harga yang ditujukan ke vendor ini
     */
    public function perbandinganHargas()
    {
        return $this->belongsToMany(PerbandinganHarga::class, 'perbandingan_harga_vendor', 'vendor_id', 'perbandingan_id')
            ->withPivot([
                'status_penawaran',
                'tanggal_respon',
                // 'catatan_vendor',
                'batas_waktu_penawaran',
            ])
            // ->withTimestamps();
            ;
    }

    /**
     * Ambil penawaran yang masih aktif (belum lewat batas waktu)
     */
    public function penawaranAktif()
    {
        return $this->perbandinganHargas()->wherePivot('batas_waktu', '>=', now());
    }

    /**
     * Ambil penawaran yang sudah kadaluarsa
     */
    public function penawaranKadaluarsa()
    {
        return $this->perbandinganHargas()->wherePivot('batas_waktu', '<', now());
    }
}
