<?php

namespace App\Exports;

use App\Models\RiwayatBarang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class RiwayatBarangExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $nomor_pengajuan;
    protected $start_date;
    protected $end_date;

    public function __construct($search = null, $nomor_pengajuan = null, $start_date = null, $end_date = null)
    {
        $this->search = $search;
        $this->nomor_pengajuan = $nomor_pengajuan;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $query = DB::table('riwayat_barang')
            ->join('pengajuan_pembelian_barang', 'riwayat_barang.pengajuan_id', '=', 'pengajuan_pembelian_barang.id')
            ->select('riwayat_barang.*', 'pengajuan_pembelian_barang.nomor', 'pengajuan_pembelian_barang.tanggal');

        if ($this->search) {
            $query->where('riwayat_barang.nama_barang', 'like', '%' . $this->search . '%');
        }

        if ($this->nomor_pengajuan) {
            $query->where('pengajuan_pembelian_barang.nomor', $this->nomor_pengajuan);
        }

        if ($this->start_date) {
            $query->whereDate('pengajuan_pembelian_barang.tanggal', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('pengajuan_pembelian_barang.tanggal', '<=', $this->end_date);
        }

        $data = $query->orderBy('pengajuan_pembelian_barang.tanggal', 'desc')->get();

        return view('exports.riwayat-barang', [
            'riwayat_barang' => $data
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1    => ['font' => ['bold' => true]],
        ];
    }
}