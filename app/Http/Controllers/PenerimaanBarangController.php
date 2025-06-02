<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanBarang;
use Illuminate\Support\Facades\DB;
use App\Models\PemesananBarang;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificationHandler;
use Illuminate\Support\Facades\Notification;


class PenerimaanBarangController extends Controller
{
    //
    public function index()
    {
        $list_penerimaan = PenerimaanBarang::with('pemesanan', 'vendor')->withCount('detail')->paginate(10);
        return view('pages.penerimaan', compact('list_penerimaan'));
    }

    public function create()
    {
        return view('pages.penerimaan-form');
    }

    public function cariPemesanan()
    {
        $list_pemesanan = PemesananBarang::withCount('detail')
            ->whereDoesntHave('penerimaan', function ($query) {
                $query->where('batal', 0);
            })
            ->where('batal', 0)
            ->get();

        return view('pages.penerimaan-list-pemesanan', compact('list_pemesanan'));
    }

    public function pilihPemesanan(PemesananBarang $pemesanan_barang)
    {
        $pemesanan_barang->load('detail', 'vendor', 'user');

        return view('pages.penerimaan-data-pemesanan', ['pemesanan' => $pemesanan_barang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_penerimaan' => 'required',
            'pengantar' => 'required',
            'penerima' => 'required',
            'nomor_pemesanan' => 'required'
        ]);
        // validasi data benar diinput ke db
        DB::beginTransaction();
        try {
            $pemesanan = PemesananBarang::with('detail', 'perbandingan.pengajuan.user')->where('nomor', $request->nomor_pemesanan)->first();
            if (!$pemesanan) {
                throw new \Exception("Data pemesanan tidak ditemukan", 1);
            }

            if (count($request->keterangan) < $pemesanan->detail->count()) {
                throw new \Exception("Wajib mengisi keterangan untuk setiap barang", 1);
            }

            $penerimaan = PenerimaanBarang::create([
                'pemesanan_id' => $pemesanan->id,
                'nomor' => numbering('penerimaan_barang', 'PB' . date('ym')),
                'tanggal_penerimaan' => $request->tanggal_penerimaan,
                'vendor_id' => $pemesanan->vendor_id,
                'pengantar' => $request->pengantar,
                'penerima' => $request->penerima,
                // 'user_id' => Auth::id() // Perbaikan di sini
                'user_id' => Auth::user()->id // Perbaikan di sini
            ]);

            $penerimaan_detail = [];
            foreach ($pemesanan->detail as $pemesanan_detail) {
                $penerimaan_detail[] = [
                    'pemesanan_barang_detail_id' => $pemesanan_detail->id,
                    'nama_barang' => $pemesanan_detail->nama_barang,
                    'jumlah' => $pemesanan_detail->jumlah,
                    'keterangan' => $request->keterangan[$pemesanan_detail->id]
                ];
            }

            $penerimaan->detail()->createMany($penerimaan_detail);
            $pemesanan->detail()->update(['penerimaan' => 1]);

            $pengajuan = $pemesanan->perbandingan->pengajuan;
            $target = $pengajuan->user;
            $data_notif = [
                'user' => Auth::user()->name, //diganti disini
                'message' => "Pengajuan barang nomor $pengajuan->nomor sudah datang",
                'redirect_url' => "penerimaan-barang/$pemesanan->id?ref=notification"
            ];
            Notification::send($target, new NotificationHandler($pemesanan, $data_notif));

            DB::commit();
            return redirect('penerimaan-barang')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show(PenerimaanBarang $penerimaan_barang)
    {
        $penerimaan_barang->load('detail', 'vendor', 'user');
        request()->user()->markAsReadNotificationFor($penerimaan_barang->pemesanan);
        return view('pages.penerimaan-detail', ['penerimaan' => $penerimaan_barang]);
    }

    public function batal(Request $request, PenerimaanBarang $penerimaan_barang)
    {
        try {
            $penerimaan_barang->fill([
                'batal' => 1,
                'keterangan_batal' => $request->keterangan,
                'tanggal_batal' => now()
            ])->save();
            return redirect('penerimaan-barang')->with('success', 'Data berhasil dibatalkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
