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

         if ($user->hasRole('vendor_rekanan')) {
            $vendorId = $user->vendor->id ?? null;

            $list_penawaran = PerbandinganHarga::whereHas('perbandinganHargaVendor', function ($query) use ($vendorId) {
                    $query->where('vendor_id', $vendorId);
                })
                ->with(['perbandinganHargaVendor' => function ($query) use ($vendorId) {
                    $query->where('vendor_id', $vendorId);
                }])
                ->orderBy('tanggal', 'desc')
                ->paginate(10);

            return view('pages.perbandingan-vendor.index', compact('list_penawaran'));
        } else {
            $list_perbandingan = PerbandinganHarga::withCount([
                    'pemesanan' => fn ($query) => $query->where('batal', 0)
                ])
                ->with('pengajuan', 'user')
                ->paginate(10);

            return view('pages.perbandingan', compact('list_perbandingan'));
        }
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
        $perbandingan_harga->load([
            'pengajuanDetail',
            'perbandinganHargaVendor.vendor',
            'perbandinganHargaVendor.hargaBarangIndexed'
        ]);

        $list_vendor = $perbandingan_harga->getListVendorWithHargaBarang();

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

   public function simpanVendor(Request $request, $id)
    {
        $request->validate([
            'vendor_ids' => 'required|array',
            'vendor_ids.*' => 'exists:vendor,id',
            'batas_waktu_penawaran' => 'required|date|after:now',
        ]);

        DB::beginTransaction();

        try {
            $perbandingan = PerbandinganHarga::findOrFail($id);

            foreach ($request->vendor_ids as $vendorId) {
                // Cek apakah vendor sudah pernah ditambahkan
                $existing = $perbandingan->vendors()->where('vendor_id', $vendorId)->exists();

                if (!$existing) {
                   $vendor = Vendor::findOrFail($vendorId); // ambil data vendor

                    $perbandingan->vendors()->attach($vendorId, [
                        'status_penawaran' => 'pending',
                        'tanggal_respon' => null,
                        'batas_waktu_penawaran' => $request->batas_waktu_penawaran,
                        'pic' => $vendor->pic, // isi otomatis dari tabel vendor
                        'kontak_pic' => $vendor->kontak_pic,
                    ]);

                }
            }

            DB::commit();

            return redirect()->route('perbandingan-harga.list-vendor', $perbandingan->id)
                ->with('success', 'Undangan berhasil dikirim ke vendor terpilih.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $th->getMessage());
        }
    }


    public function konfirmasiUndangan(PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $user = Auth::user();

        if ($user->vendor->id !== $perbandingan_harga_vendor->vendor_id) {
            abort(403);
        }

        // Tambahkan eager loading
        $perbandingan_harga_vendor->load('perbandinganHarga.pengajuanDetail', 'vendor', 'perbandinganHarga.user');

        // Cek jika sudah melewati batas waktu
        if (
            $perbandingan_harga_vendor->status_penawaran === 'pending' &&
            $perbandingan_harga_vendor->batas_waktu_penawaran &&
            now()->gt($perbandingan_harga_vendor->batas_waktu_penawaran)
        ) {
            $perbandingan_harga_vendor->update(['status_penawaran' => 'berakhir']);
        }

        return view('pages.perbandingan-vendor.konfirmasi', compact('perbandingan_harga_vendor'));
    }

    public function prosesKonfirmasiUndangan(Request $request, PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $aksi = $request->input('aksi');

        if ($aksi === 'setuju') {
            $perbandingan_harga_vendor->status_penawaran = 'disetujui';
            $perbandingan_harga_vendor->tanggal_respon = now();
            $perbandingan_harga_vendor->save();

            return redirect()->route('perbandingan-harga.vendor.index')
                ->with('success', 'Anda telah menyetujui undangan penawaran.');
        }

        if ($aksi === 'tolak') {
            $perbandingan_harga_vendor->status_penawaran = 'ditolak';
            $perbandingan_harga_vendor->tanggal_respon = now();
            $perbandingan_harga_vendor->save();

            return redirect()->route('perbandingan-harga.vendor.index')
                ->with('success', 'Anda telah menolak undangan penawaran.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }


    public function isiHargaVendor(PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $user = Auth::user();

        if ($user->vendor->id !== $perbandingan_harga_vendor->vendor_id) {
            abort(403, 'Akses ditolak.');
        }

        // Validasi status & waktu
        if ($perbandingan_harga_vendor->status_penawaran !== 'disetujui') {
            return redirect()->route('dashboard')->with('error', 'Anda belum menyetujui undangan.');
        }

        if (now()->greaterThan($perbandingan_harga_vendor->batas_waktu_penawaran)) {
            $perbandingan_harga_vendor->update(['status_penawaran' => 'berakhir']);
            return redirect()->route('dashboard')->with('error', 'Batas waktu telah berakhir.');
        }

        $perbandingan = $perbandingan_harga_vendor->perbandinganHarga()
            ->with('pengajuanDetail')
            ->first();

        // Ambil data item harga lama (kalau ada)
        $itemHarga = $perbandingan_harga_vendor->perbandinganHargaItemBarang()
            ->pluck('harga_satuan', 'pengajuan_barang_detail_id')
            ->toArray();

        return view('pages.perbandingan-vendor.isi-harga', [
            'perbandingan_harga_vendor' => $perbandingan_harga_vendor,
            'perbandingan' => $perbandingan,
            'harga_satuan' => $itemHarga
        ]);
    }


   public function simpanHargaVendor(Request $request, PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $request->validate([
            'ketentuan_pembayaran' => 'required|string',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Simpan ketentuan pembayaran ke tabel pivot
            $perbandingan_harga_vendor->ketentuan_pembayaran = $request->ketentuan_pembayaran;
            $perbandingan_harga_vendor->save();

            // Ambil semua barang dari relasi pengajuan detail
            $pengajuanDetail = $perbandingan_harga_vendor->perbandinganHarga->pengajuanDetail->keyBy('id');

            foreach ($request->harga_satuan as $detail_id => $harga) {
                // validasi bahwa barang ini memang termasuk ke pengajuan
                if (!isset($pengajuanDetail[$detail_id])) {
                    continue;
                }

                $barang = $pengajuanDetail[$detail_id];

                // cari item lama
                $item = $perbandingan_harga_vendor->perbandinganHargaItemBarang()
                            ->where('pengajuan_barang_detail_id', $detail_id)
                            ->first();

                if ($item) {
                    $item->update([
                        'harga_satuan' => $harga,
                        'jumlah' => $barang->jumlah,
                        'nama_barang' => $barang->nama_barang,
                        'spesifikasi' => $barang->spesifikasi,
                    ]);
                } else {
                    // insert baru
                    PerbandinganHargaItemBarang::create([
                        'perbandingan_vendor_id' => $perbandingan_harga_vendor->id,
                        'pengajuan_barang_detail_id' => $detail_id,
                        'harga_satuan' => $harga,
                        'jumlah' => $barang->jumlah,
                        'nama_barang' => $barang->nama_barang,
                        'spesifikasi' => $barang->spesifikasi,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('perbandingan-harga.vendor.index')
                ->with('success', 'Harga berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th); // Tambahan log error
            return back()->with('error', 'Gagal menyimpan: ' . $th->getMessage());
        }
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
        return view('pages.perbandingan-vendor.edit', [
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
            // Tandai perbandingan selesai
            $perbandingan_harga->fill(['selesai' => 1])->save();

            // Update status semua vendor menjadi 'berakhir'
            $perbandingan_harga->perbandinganHargaVendor()->update(['status_penawaran' => 'berakhir']);

            // Kirim notifikasi
            $target = User::role(['vendor_rekanan', 'divisi'])->get();
            $data_notif = [
                'user' => Auth::user()->name,
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

    //controler untuk vendor
    public function listVendorForVendor()
    {
        $user = Auth::user();
        $vendor = $user->vendor;

        if (!$vendor) {
            abort(403, 'Akun Anda belum terhubung dengan data vendor.');
        }

        $vendorId = $vendor->id;

        $list_penawaran = PerbandinganHarga::whereHas('perbandinganHargaVendor', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })
            ->with(['perbandinganHargaVendor' => function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            }])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('pages.perbandingan-vendor.index', compact('list_penawaran'));
    }


    public function previewVendor(PerbandinganHargaVendor $perbandingan_harga_vendor)
    {
        $user = Auth::user();
        if ($user->vendor->id !== $perbandingan_harga_vendor->vendor_id) {
            abort(403);
        }

        return view('pages.perbandingan-vendor.preview', [
            'perbandingan_vendor' => $perbandingan_harga_vendor->load('perbandinganHargaItemBarang', 'vendor', 'perbandinganHarga')
        ]);
    }

}
