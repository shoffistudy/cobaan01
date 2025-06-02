<?php

namespace App\Http\Controllers;

use App\Models\PemesananBarang;
use App\Models\PerbandinganHarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use App\Models\User;
use App\Notifications\NotificationHandler;
use Illuminate\Support\Facades\Notification;
use App\Models\Notification as ModelsNotification;


class PemesananBarangController extends Controller
{
    //
    public function index()
    {
        // ada perubahan disini
        $list_pemesanan = PemesananBarang::with('user', 'perbandingan', 'vendor')
            ->withCount([
                'detail',
                'penerimaan' => fn ($query) => $query->where('batal', 0)
            ])
            ->paginate(10);        

        return view('pages.pemesanan', compact('list_pemesanan'));
    }

        public function create()
    {
        return view('pages.pemesanan-form');
    }

    public function cariPerbandingan()
    {
        $list_perbandingan = PerbandinganHarga::withCount('perbandinganHargaVendor')
            ->whereDoesntHave('pemesanan', function ($query) {
                $query->where('batal', 0);
            })
            ->where('selesai', 1)
            ->get();

        return view('pages.pemesanan-list-perbandingan', compact('list_perbandingan'));
    }

    public function pilihPerbandingan(PerbandinganHarga $perbandingan_harga)
    {
        $perbandingan_harga->load(
            'pengajuanDetail',
            'perbandinganHargaVendor.perbandinganHargaItemBarang',
            'perbandinganHargaVendor.vendor'
        );
        $list_vendor = [];
        foreach ($perbandingan_harga->perbandinganHargaVendor as $perbandingan_harga_vendor) {
            $nama_vendor = $perbandingan_harga_vendor->vendor->nama;
            $list_vendor[$nama_vendor] = $perbandingan_harga_vendor->perbandinganHargaItemBarang
                ->keyBy('pengajuan_barang_detail_id')
                ->map(function ($item) {
                    return [
                        'perbandingan_vendor_id' => $item->perbandingan_vendor_id,
                        'nama_barang' => $item->nama_barang,
                        'harga_satuan' => $item->harga_satuan,
                        'total_harga' => $item->jumlah * $item->harga_satuan
                    ];
                })->toArray();
        }

        return view('pages.pemesanan-data-perbandingan', [
            'perbandingan' => $perbandingan_harga,
            'list_vendor' => $list_vendor
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['nomor_perbandingan' => 'required']);
        DB::beginTransaction();
        try {
            $perbandingan_harga = PerbandinganHarga::withCount('pengajuanDetail')
                ->with('perbandinganHargaVendor.perbandinganHargaItemBarang')
                ->where('nomor', $request->nomor_perbandingan)
                ->first();
            if (!$perbandingan_harga) {
                throw new \Exception("Data perbandingan harga tidak ditemukan", 1);
            }

            if (count($request->barang) < $perbandingan_harga->pengajuan_detail_count) {
                throw new \Exception("Jumlah barang yang dipilih tidak sesuai, harus semua dipilih!", 1);
            }

            $list_barang_group_vendor = [];
            foreach ($request->barang as $pengajuan_detail_id => $perbandingan_harga_vendor_id) {
                $list_barang_group_vendor[$perbandingan_harga_vendor_id][] = $pengajuan_detail_id;
            }

            foreach ($list_barang_group_vendor as $perbandingan_harga_vendor_id => $list_pengajuan_detail_id) {
                // Mencari perbandingan harga vendor berdasarkan id nya.
                $perbandingan_harga_vendor = $perbandingan_harga->perbandinganHargaVendor->firstWhere('id', $perbandingan_harga_vendor_id);
            
                /**
                 * Menyimpan data pemesanan barang ke database
                 * @var \App\Models\PemesananBarang
                 */
                $pemesanan = PemesananBarang::create([
                    'nomor' => numbering('pemesanan_barang', 'PB' . date('ym')),
                    'perbandingan_id' => $perbandingan_harga->id,
                    'vendor_id' => $perbandingan_harga_vendor->vendor_id,
                    'npwp' => $perbandingan_harga_vendor->vendor->npwp,
                    'pic' => $perbandingan_harga_vendor->pic,
                    'kontak_pic' => $perbandingan_harga_vendor->kontak_pic,
                    'user_id' => Auth::user()->id
                ]);
            
                // Mapping list barang dengan nama, spesifikasi, jumlah dan harga yang sesuai dengan perbandingan
                $pemesanan_detail = [];
                foreach ($list_pengajuan_detail_id as $pengajuan_detail_id) {
                    $perbandingan_harga_item_barang = $perbandingan_harga_vendor->perbandinganHargaItemBarang->firstWhere('pengajuan_barang_detail_id', $pengajuan_detail_id);
                    $pemesanan_detail[] = [
                        'perbandingan_barang_id' => $perbandingan_harga_item_barang->id,
                        'nama_barang' => $perbandingan_harga_item_barang->nama_barang,
                        'spesifikasi' => $perbandingan_harga_item_barang->spesifikasi,
                        'jumlah' => $perbandingan_harga_item_barang->jumlah,
                        'harga_satuan' => $perbandingan_harga_item_barang->harga_satuan
                    ];
                }
            
                // Menyimpan list barang ke tabel pemesanan_barang_detail dari relasi detail
                $pemesanan->detail()->createMany($pemesanan_detail);
            
                // Mengubah status perbandingan harga item barang menjadi sudah pemesanan
                $perbandingan_harga_vendor->perbandinganHargaItemBarang()
                    ->whereIn('pengajuan_barang_detail_id', $list_pengajuan_detail_id)
                    ->update(['pemesanan' => 1]);

                
                    //$target = User::role('staff_finance')->get();
                    $target = User::role('admin_logistik')->get();
                    $data_notif = [
                        'user' => Auth::user()->name, //diganti disini
                        'message' => "Pemesanan baru nomor $pemesanan->nomor",
                        'redirect_url' => "pemesanan-barang/$pemesanan->id?ref=notification"
                    ];
                    Notification::send($target, new NotificationHandler($pemesanan, $data_notif));
    
                    request()->user()->markAsReadNotificationFor($perbandingan_harga);
            }
            

            DB::commit();
            return redirect('pemesanan-barang')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show(PemesananBarang $pemesanan_barang)
    {
        $pemesanan_barang->load(
            'vendor',
            'detail',
            'user'
        );
        request()->user()->markAsReadNotificationFor($pemesanan_barang);
        return view('pages.pemesanan-detail', ['pemesanan' => $pemesanan_barang]);
    }

    public function batal(Request $request, PemesananBarang $pemesanan_barang)
    {
        DB::beginTransaction();
        try {
            $pemesanan_barang->fill([
                'batal' => 1,
                'keterangan_batal' => $request->keterangan,
                'tanggal_batal' => now()
            ])->save();

            ModelsNotification::whereNull('read_at')
            ->where('model_id', $pemesanan_barang->id)
            ->where('model_type', get_class($pemesanan_barang))
            ->update(['read_at' => now()]);

            DB::commit();

            return redirect('pemesanan-barang')->with('success', 'Data berhasil dibatalkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function cetak(PemesananBarang $pemesanan_barang)
    {
        $pemesanan_barang->load('detail', 'vendor');
        $pdf = DomPDF::loadView('pages.pemesanan-cetak', ['pemesanan' => $pemesanan_barang]);
        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream();
    }
}
