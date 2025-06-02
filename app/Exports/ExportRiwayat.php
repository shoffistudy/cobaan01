<?php

namespace App\Exports;

use App\Models\PengajuanPembelianBarangDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportRiwayat implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return PengajuanPembelianBarangDetail::orderBy('nama_barang')->get();
        return $data;
    }
}
