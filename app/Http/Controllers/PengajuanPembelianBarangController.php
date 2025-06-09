<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPembelianBarang;
use App\Models\PengajuanPembelianBarangDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportRiwayat;
use App\Models\RiwayatBarang;
use App\Imports\BarangImport;
use App\Exports\TemplateBarangExport;
use App\Notifications\NotificationHandler;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as ModelsNotification;


class PengajuanPembelianBarangController extends Controller
{
    public function index()
    {
       /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('read pengajuan-pembelian-barang')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $list_pengajuan = PengajuanPembelianBarang::withCount('detail', 'perbandingan')
            ->with('user')
            ->where(function ($query) use ($user) {
                if ($user->hasRole('divisi')) { //jika role user adalah karyawan
                    $query->where('user_id', $user->id);
                }
            })->paginate(10);

        return view('pages.pengajuan', compact('list_pengajuan'));
    }

    public function create(PengajuanPembelianBarang $pengajuan_pembelian_barang)
    {
        /**
         * @var \App\Models\User
         */
        //$user = auth()->user();
        $user = Auth::user();

        if ($user->cannot('create pengajuan-pembelian-barang')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        return view('pages.pengajuan-form-input', ['pengajuan' => $pengajuan_pembelian_barang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengajuan' => 'required|max:255',
            'keterangan' => 'required',
            'nama_barang' => 'required|array|min:1',
            'nama_barang.*' => 'required',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|numeric',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric',
            'spesifikasi' => 'required|array|min:1',
            'spesifikasi.*' => 'required',
        ], [
            'nama_barang.*.required' => 'Nama barang wajib diisi',
            'jumlah.*.required' => 'Jumlah barang wajib diisi',
            'harga_satuan.*.required' => 'Harga satuan barang wajib diisi',
            'spesifikasi.*.required' => 'Spesifikasi barang wajib diisi',
        ]);
        DB::beginTransaction();
        try {
            /**
             * @var \App\Models\PengajuanPembelianBarang
             */
            $pengajuan = PengajuanPembelianBarang::create([
                'nomor' => numbering('pengajuan_pembelian_barang', 'PPB' . date('ym')),
                'nama_pengajuan' => $request->nama_pengajuan,
                'keterangan' => $request->keterangan,
                'user_id' => Auth::id() // Perbaikan di sini
            ]);

            $list_barang = [];
            foreach ($request->nama_barang as $key => $nama_barang) {
                $list_barang[] = new PengajuanPembelianBarangDetail([
                    'nama_barang' => $nama_barang,
                    'spesifikasi' => $request->spesifikasi[$key],
                    'jumlah' => $request->jumlah[$key],
                    'harga_satuan' => $request->harga_satuan[$key]
                ]);

                // Menyimpan ke Riwayat Barang
                RiwayatBarang::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $nama_barang,
                    'spesifikasi' => $request->spesifikasi[$key],
                    'jumlah' => $request->jumlah[$key],
                    'harga_satuan' => $request->harga_satuan[$key],
                    'total' => $request->jumlah[$key] * $request->harga_satuan[$key]
            ]);
            }

            $pengajuan->detail()->saveMany($list_barang);

            // notifikasi
            
            $target = User::role('admin_logistik')->get(); //untuk admin
            $data_notif = [
                //'user' => auth()->user()->name,
                'user' => Auth::user()->name, //diganti disini
                'message' => "Pengajuan baru nomor $pengajuan->nomor",
                'redirect_url' => "pengajuan-pembelian-barang/$pengajuan->id?ref=notification"
            ];
            Notification::send($target, new NotificationHandler($pengajuan, $data_notif));

            DB::commit();
            return redirect('pengajuan-pembelian-barang')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    
    public function edit(PengajuanPembelianBarang $pengajuan_pembelian_barang)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('update pengajuan-pembelian-barang')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $pengajuan_pembelian_barang->load('detail');

        return view('pages.pengajuan-form-edit', ['pengajuan' => $pengajuan_pembelian_barang]);
    }

    public function update(Request $request, PengajuanPembelianBarang $pengajuan_pembelian_barang)
    {
        $request->validate([
            'nama_pengajuan' => 'required|max:255',
            'keterangan' => 'required',
            'nama_barang' => 'required|array|min:1',
            'nama_barang.*' => 'required',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|numeric',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric',
            'spesifikasi' => 'required|array|min:1',
            'spesifikasi.*' => 'required',
        ], [
            'nama_barang.*.required' => 'Nama barang wajib diisi',
            'jumlah.*.required' => 'Jumlah barang wajib diisi',
            'harga_satuan.*.required' => 'Harga satuan barang wajib diisi',
            'spesifikasi.*.required' => 'Spesifikasi barang wajib diisi',
        ]);
        DB::beginTransaction();
        try {
            $pengajuan_pembelian_barang->fill([
                'nama_pengajuan' => $request->nama_pengajuan,
                'keterangan' => $request->keterangan,
            ])->save();

            // Menghapus riwayat barang lama
            RiwayatBarang::where('pengajuan_id', $pengajuan_pembelian_barang->id)->delete();
            $pengajuan_pembelian_barang->detail()->delete();

            $list_barang = [];
            foreach ($request->nama_barang as $key => $nama_barang) {
                $list_barang[] = new PengajuanPembelianBarangDetail([
                    'nama_barang' => $nama_barang,
                    'spesifikasi' => $request->spesifikasi[$key],
                    'jumlah' => $request->jumlah[$key],
                    'harga_satuan' => $request->harga_satuan[$key]
                ]);

                 // Menyimpan riwayat barang baru
                RiwayatBarang::create([
                    'pengajuan_id' => $pengajuan_pembelian_barang->id,
                    'nama_barang' => $nama_barang,
                    'spesifikasi' => $request->spesifikasi[$key],
                    'jumlah' => $request->jumlah[$key],
                    'harga_satuan' => $request->harga_satuan[$key],
                    'total' => $request->jumlah[$key] * $request->harga_satuan[$key]
                ]);
            }

            $pengajuan_pembelian_barang->detail()->saveMany($list_barang);

            //notifikasi
            $target = User::role('admin_logistik')->get();
            $data_notif = [
                //'user' => auth()->user()->name,
                'user' => Auth::user()->name, //diganti disini
                'message' => "Perubahan pengajuan nomor $pengajuan_pembelian_barang->nomor",
                'redirect_url' => "pengajuan-pembelian-barang/$pengajuan_pembelian_barang->id?ref=notification"
            ];
            Notification::send($target, new NotificationHandler($pengajuan_pembelian_barang, $data_notif));


            DB::commit();
            return redirect('pengajuan-pembelian-barang')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function show(PengajuanPembelianBarang $pengajuan_pembelian_barang)
    {
        $pengajuan_pembelian_barang->load('detail');
        return view('pages.pengajuan-detail', ['pengajuan' => $pengajuan_pembelian_barang]);
    }

    public function showRiwayat($id)
    {
        // Mengambil pengajuan berdasarkan ID dan menggabungkannya dengan riwayat barang
        $pengajuan = PengajuanPembelianBarang::with('riwayatBarang')->findOrFail($id); // Mengambil pengajuan dan riwayat barang terkait

        // Mengirim data pengajuan dan riwayat barang ke view
        return view('pages.riwayat-barang', compact('pengajuan'));
    }

    public function cetakExcel(Request $request)
    {
        // Mengekspor riwayat barang menggunakan eksport kelas
        return Excel::download(new ExportRiwayat, 'riwayat_barang.xlsx');
    }

    public function batal(Request $request, PengajuanPembelianBarang $pengajuan_pembelian_barang)
    {
        DB::beginTransaction();
        try {
            $pengajuan_pembelian_barang->fill([
                'batal' => 1,
                'keterangan_batal' => $request->keterangan,
                'tanggal_batal' => now()
            ])->save();

            ModelsNotification::whereNull('read_at')
            ->where('model_id', $pengajuan_pembelian_barang->id)
            ->where('model_type', get_class($pengajuan_pembelian_barang))
            ->update(['read_at' => now()]);

        DB::commit();

            return redirect('pengajuan-pembelian-barang')->with('success', 'Data berhasil dibatalkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
    * Download template Excel untuk input barang
    */
    public function downloadTemplate()
    {
        return Excel::download(new TemplateBarangExport, 'template_barang_pengajuan.xlsx');
    }

    // /**
    //  * Upload dan parse Excel file
    //  */
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048'
        ], [
            'excel_file.required' => 'File Excel harus dipilih',
            'excel_file.file' => 'File yang dipilih tidak valid',
            'excel_file.mimes' => 'File harus berformat Excel (.xlsx atau .xls)',
            'excel_file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $import = new BarangImport;
            Excel::import($import, $request->file('excel_file'));
            
            $data = $import->getData();
            
            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File Excel kosong atau tidak memiliki data yang valid'
                ]);
            }

            // Format data untuk frontend
            $formattedData = [];
            foreach ($data as $row) {
                $formattedData[] = [
                    'nama_barang' => $row['nama_barang'] ?? '',
                    'spesifikasi' => $row['spesifikasi'] ?? '',
                    'jumlah' => $row['jumlah'] ?? '',
                    'harga_satuan' => $row['harga_satuan'] ?? ''
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'message' => 'File Excel berhasil diproses. ' . count($formattedData) . ' item ditemukan.'
            ]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()
            ]);
        }
    }
}