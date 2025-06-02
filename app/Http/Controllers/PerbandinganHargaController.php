<?php

namespace App\Http\Controllers;

use App\Models\PerbandinganHarga;
use App\Models\PengajuanPembelianBarang;
use App\Models\PerbandinganHargaVendor;
use App\Models\Vendor;
use App\Models\PerbandinganHargaItemBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\NotificationHandler;
use Illuminate\Support\Facades\Notification;


class PerbandinganHargaController extends Controller
{
    //
    public function index()
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('read perbandingan-harga')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $list_perbandingan = PerbandinganHarga::withCount([
            'pemesanan' => fn ($query) => $query->where('batal', 0)
        ])->with('pengajuan', 'user')->paginate(10);
        return view('pages.perbandingan', compact('list_perbandingan'));
    }

    public function create(PerbandinganHarga $perbandinganHarga)
    {
        /**
         * @var \App\Models\User
         */
        //$user = auth()->user();
        $user = Auth::user();
        if ($user->cannot('create perbandingan-harga')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        return view('pages.perbandingan-form', ['perbandingan' => $perbandinganHarga]);
    }

    public function cariPengajuan()
    {
        $list_pengajuan = PengajuanPembelianBarang::withCount('detail')
            ->doesntHave('perbandingan')
            ->where('batal', 0)
            ->orWhere('id', request('id'))
            ->get();

        return view('pages.perbandingan-list-pengajuan', compact('list_pengajuan'));
    }

    public function pilihPengajuan(PengajuanPembelianBarang $pengajuan)
    {
        $pengajuan->load('detail');
        return view('pages.perbandingan-data-pengajuan', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'nomor_pengajuan' => 'required'
        ]);
        try {
            $pengajuan = PengajuanPembelianBarang::where('nomor', $request->nomor_pengajuan)->first();
            if (!$pengajuan) {
                throw new \Exception("Pengajuan tidak ditemukan", 1);
            }

            PerbandinganHarga::create([
                'nomor' => numbering('perbandingan_harga', 'PH' . date('ym')),
                'judul' => $request->judul,
                'pengajuan_id' => $pengajuan->id,
                'user_id' => Auth::id() // Perbaikan
            ]);

            request()->user()->markAsReadNotificationFor($pengajuan);

            return redirect('perbandingan-harga')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(PerbandinganHarga $perbandingan_harga)
    {
        /**
         * @var \App\Models\User
         */
        //$user = auth()->user();
        $user = Auth::user();
        if ($user->cannot('update perbandingan-harga')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $perbandingan_harga->load('pengajuan');
        return view('pages.perbandingan-form', ['perbandingan' => $perbandingan_harga]);
    }

    public function update(Request $request, PerbandinganHarga $perbandingan_harga)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'nomor_pengajuan' => 'required'
        ]);
        try {
            $pengajuan = PengajuanPembelianBarang::where('nomor', $request->nomor_pengajuan)->first();
            if (!$pengajuan) {
                throw new \Exception("Pengajuan tidak ditemukan", 1);
            }

            $perbandingan_harga->fill([
                'judul' => $request->judul,
                'pengajuan_id' => $pengajuan->id
            ])->save();

            return redirect('perbandingan-harga')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function listVendor(PerbandinganHarga $perbandingan_harga)
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
                        'nama_barang' => $item->nama_barang,
                        'harga_satuan' => $item->harga_satuan,
                        'total_harga' => $item->jumlah * $item->harga_satuan,
                        'pemesanan' => $item->pemesanan
                    ];
                })->toArray();
        }

        return view('pages.perbandingan-list-vendor', [
            'perbandingan' => $perbandingan_harga,
            'list_vendor' => $list_vendor
        ]);
    }

    public function tambahVendor(PerbandinganHarga $perbandingan_harga)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        if ($user->cannot('create perbandingan-harga')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $perbandingan_harga->load('pengajuanDetail');
        $vendors = Vendor::whereNotIn('id', $perbandingan_harga->perbandinganHargaVendor->pluck('vendor_id')->toArray())->get();

        return view('pages.perbandingan-form-tambah-vendor', [
            'perbandingan' => $perbandingan_harga,
            'vendors' => $vendors
        ]);
    }

   public function simpanVendor(Request $request, PerbandinganHarga $perbandingan_harga)
    {
        $request->validate([
            'vendor_ids' => 'required|array',
            'vendor_ids.*' => 'exists:vendor,id',
            'batas_waktu_penawaran' => 'required|date|after:now',
        ]);

        DB::beginTransaction();
        try {
            $batasWaktu = $request->batas_waktu_penawaran;

            foreach ($request->vendor_ids as $vendor_id) {
                $vendor = Vendor::find($vendor_id);

                $perbandingan_harga->perbandinganHargaVendor()->create([
                    'vendor_id' => $vendor->id,
                    'pic' => $vendor->pic,
                    'kontak_pic' => $vendor->kontak_pic,
                    'ketentuan_pembayaran' => null,
                    'status_penawaran' => 'penawaran',
                    'batas_waktu_penawaran' => $batasWaktu
                ]);
            }

            DB::commit();
            return redirect()->route('perbandingan-harga.list-vendor', $perbandingan_harga->id)
                            ->with('success', 'Vendor berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }   


    public function konfirmasiUndangan(PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
         /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        if ($user->vendor->id !== $perbandingan_harga_vendor->vendor_id) {
            abort(403);
        }

        return view('vendor.konfirmasi-undangan', compact('perbandingan_harga_vendor'));
    }

    public function prosesKonfirmasiUndangan(Request $request, PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $request->validate([
            'aksi' => 'required|in:setuju,tolak'
        ]);

         /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        if ($user->vendor->id !== $perbandingan_harga_vendor->vendor_id) {
            abort(403);
        }

        $perbandingan_harga_vendor->status_penawaran = $request->aksi === 'setuju' ? 'disetujui' : 'ditolak';
        $perbandingan_harga_vendor->tanggal_respon = now();
        $perbandingan_harga_vendor->save();

        return redirect()->route('dashboard')->with('success', 'Konfirmasi berhasil dikirim.');
    }


    public function editVendor(PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
         /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        // Pastikan user vendor yang sah
        if ($user->vendor->id !== $perbandingan_harga_vendor->vendor_id) {
            abort(403, 'Kamu tidak diizinkan mengakses data ini.');
        }

        // Cek status penawaran
        if ($perbandingan_harga_vendor->status_penawaran === 'ditolak') {
            return redirect()->route('dashboard')->with('error', 'Anda telah menolak undangan penawaran.');
        }

        // Cek batas waktu
        if ($perbandingan_harga_vendor->batas_waktu_penawaran && now()->greaterThan($perbandingan_harga_vendor->batas_waktu_penawaran)) {
            if ($perbandingan_harga_vendor->status_penawaran !== 'berakhir') {
                $perbandingan_harga_vendor->update(['status_penawaran' => 'berakhir']);
            }

            return redirect()->route('dashboard')->with('error', 'Penawaran ini sudah berakhir.');
        }

        // Cek apakah vendor sudah menyetujui undangan
        if ($perbandingan_harga_vendor->status_penawaran !== 'disetujui') {
            return redirect()->route('dashboard')->with('error', 'Silakan setujui undangan terlebih dahulu.');
        }

        // Semua valid, tampilkan form input harga
        $perbandingan_harga_vendor->load('perbandinganHargaItemBarang');
        return view('pages.perbandingan-form-edit-vendor', [
            'perbandingan_vendor' => $perbandingan_harga_vendor
        ]);
    }

    public function updateVendor(Request $request, PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $request->validate([
            'ketentuan_pembayaran' => 'required',
            'harga_satuan.*' => 'required'
        ], [
            'harga_satuan.*' => 'Harga satuan wajib diisi'
        ]);
        DB::beginTransaction();
        try {
            $perbandingan_harga_vendor->load('perbandinganHargaItemBarang');
            foreach ($perbandingan_harga_vendor->perbandinganHargaItemBarang as $barang) {
                $barang->fill(['harga_satuan' => $request->harga_satuan[$barang->id]])->save();
            }

            DB::commit();
            return redirect('perbandingan-harga/vendor/' . $perbandingan_harga_vendor->perbandingan_id)->with('success', "Data berhasil diubah");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteVendor(PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        DB::beginTransaction();
        try {
            /**
             * @var \App\Models\PerbandinganHarga
             */
            $perbandingan_harga = $perbandingan_harga_vendor->perbandinganHarga;

            $perbandingan_harga_vendor->perbandinganHargaItemBarang()->delete();
            $perbandingan_harga_vendor->delete();

            if ($perbandingan_harga->perbandinganHargaVendor()->count() == 0) {
                $perbandingan_harga->pengajuanDetail()->update(['perbandingan' => 0]);
            }

            DB::commit();
            return redirect('perbandingan-harga/vendor/' . $perbandingan_harga_vendor->perbandingan_id)->with('success', "Data berhasil dihapus");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function tandaiSelesai(PerbandinganHarga $perbandingan_harga)
    {
        DB::beginTransaction();
        try {
            $perbandingan_harga->fill(['selesai' => 1])->save();

            $target = User::role(['vendor_rekanan', 'divisi'])->get();
            $data_notif = [
                'user' => Auth::user()->name, //diganti disini
                'message' => "Perbandingan harga baru nomor $perbandingan_harga->nomor",
                'redirect_url' => "pemesanan-barang/create?ref=notification&nomor=$perbandingan_harga->nomor"
            ];
            Notification::send($target, new NotificationHandler($perbandingan_harga, $data_notif));

            DB::commit();
            return redirect()->back()->with('success', 'Perbandingan sudah ditandai selesai');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    
}
