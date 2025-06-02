<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatBarang extends Model
{
    protected $table = 'riwayat_barang'; // Nama tabel yang sesuai

    protected $fillable = [
        'pengajuan_id', 'nama_barang', 'spesifikasi', 'jumlah', 'harga_satuan', 'total'
    ];

    // Relasi ke PengajuanPembelianBarang
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPembelianBarang::class, 'pengajuan_id');
    }

    // Relasi ke User (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Asumsi ada relasi user_id pada tabel riwayat_barang
    }
}
