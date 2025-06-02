<?php

namespace App\Http\Controllers;

use App\Exports\ExportRiwayat;
use App\Models\RiwayatBarang;
use App\Models\PengajuanPembelianBarangDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Exports\RiwayatBarangExport;

class RiwayatBarangController extends Controller
{
    /**
     * Menampilkan daftar riwayat barang dengan filter pencarian.
     */
    public function index(Request $request)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        // Cek permission 'read riwayat-barang'
        if ($user->cannot('read riwayat-barang')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        // Get distinct nomor pengajuan for dropdown
        $nomor_pengajuan_list = DB::table('pengajuan_pembelian_barang')
            ->distinct()
            ->pluck('nomor');

        // Ambil data riwayat barang dengan eager loading untuk mengurangi query ke database
        $riwayat_barang = RiwayatBarang::with(['pengajuan', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_barang', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('nomor_pengajuan'), function ($query) use ($request) {
                $query->whereHas('pengajuan', function($q) use ($request) {
                    $q->where('nomor', $request->nomor_pengajuan);
                });
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereHas('pengajuan', function($q) use ($request) {
                    $q->whereDate('tanggal', '>=', $request->start_date);
                });
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereHas('pengajuan', function($q) use ($request) {
                    $q->whereDate('tanggal', '<=', $request->end_date);
                });
            })
            ->paginate(10);

        // Kirim data ke view
        return view('pages.riwayat-barang', compact('riwayat_barang', 'nomor_pengajuan_list'));
    }


    /**
     * Fungsi untuk mencari riwayat barang berdasarkan filter jenis proses dan tanggal.
     */
    public function cariBarang(Request $request)
    {
        // Menyiapkan query untuk mengambil data riwayat barang dengan filtering dan pagination
        $query = RiwayatBarang::query();

        // Filter berdasarkan jenis proses jika ada
        if ($request->has('process_type') && $request->process_type != '') {
            $query->where('process_type', $request->process_type);
        }

        // Filter berdasarkan rentang tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '' && $request->end_date != '') {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan jenis dari tabel pengajuan_pembelian_barang_detail jika ada
        if ($request->has('jenis_pengajuan') && $request->jenis_pengajuan != '') {
            $query->whereHas('pengajuanPembelianBarangDetail', function($q) use ($request) {
                $q->where('jenis', $request->jenis_pengajuan); // Asumsikan 'jenis' adalah kolom yang ingin difilter
            });
        }

        // Ambil data riwayat barang dengan pagination
        return $query->paginate(10); // Pagination
    }

    /**
     * Menyimpan riwayat barang baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'item_id' => 'required|exists:pengajuan_pembelian_barang_detail,id',
            'process_type' => 'required|in:Pengajuan,Pemesanan,Penerimaan',
            'quantity' => 'required|integer',
            'status' => 'nullable|string'
        ]);

        try {
            // Menyimpan riwayat barang
            RiwayatBarang::create([
                'item_id' => $request->item_id,
                'process_type' => $request->process_type,
                'quantity' => $request->quantity,
                'status' => $request->status,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('pages.riwayat-barang')->with('success', 'Riwayat barang berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Menampilkan detail riwayat barang tertentu.
     */
    // public function show(RiwayatBarang $riwayatBarang)
    // {
    //     // Mengirimkan detail riwayat barang ke view
    //     return view('pages.riwayat-barang-detail', compact('riwayatBarang'));
    // }

    public function showRiwayat()
    {
        $riwayat = RiwayatBarang::with('pengajuan')->get(); // Menampilkan semua riwayat barang beserta pengajuannya
        return view('pages.riwayat-barang', compact('riwayat_barang'));
    }

    /**
     * Mengekspor riwayat barang ke PDF.
     */
    public function cetakPdf(RiwayatBarang $riwayat_barang)
    {
        // Mendapatkan data riwayat barang dengan relasi ke pengajuan detail
        $riwayatBarang = RiwayatBarang::with('pengajuanDetail')->get();

        // Generate PDF menggunakan domPDF
        $pdf = Pdf::loadView('riwayat-barang.pdf', compact('riwayatBarang'));

        // Download file PDF
        return $pdf->download('riwayat_barang.pdf');
    }

    /**
     * Mengekspor riwayat barang ke Excel.
     */
    public function export(Request $request)
    {
        $search = $request->search;
        $nomor_pengajuan = $request->nomor_pengajuan;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        return Excel::download(
            new RiwayatBarangExport($search, $nomor_pengajuan, $start_date, $end_date),
            'riwayat-barang-' . date('Y-m-d') . '.xlsx'
        );
    }
}