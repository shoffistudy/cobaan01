<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\PengajuanPembelianBarang;
use App\Models\PemesananBarang;
use App\Models\PenerimaanBarang;
use App\Models\RiwayatBarang;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalVendors'    => Vendor::count(),
            'totalSubmissions'=> PengajuanPembelianBarang::count(),
            'totalOrders'     => PemesananBarang::count(),
            'totalReceipts'   => PenerimaanBarang::count(),
            'totalItems'      => RiwayatBarang::count(),
        ];

        return view('dashboard', $data);
    }
}
