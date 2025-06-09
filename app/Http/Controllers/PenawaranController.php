<?php

namespace App\Http\Controllers;

use App\Models\PerbandinganHarga;
use App\Models\PerbandinganHargaVendor;
use App\Models\PerbandinganHargaItemBarang;
use App\Models\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenawaranController extends Controller
{
    public function index()
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('read pengajuan-penawaran')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $list_perbandingan = PerbandinganHarga::with('pengajuan', 'user')->paginate(10);
        return view('pages.penawaran', compact('list_penawaran'));
    }

    public function tambahPenawaran(PerbandinganHarga $perbandingan)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('create penawaran-pengajuan')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        // Cek jika perbandingan sudah selesai
        if ($perbandingan->selesai) {
            return redirect()->route('penawaran.index')->with('error', 'Perbandingan harga sudah ditandai selesai');
        }

        $vendors = Vendor::all();
        
        // Jika user adalah vendor, pre-select vendor tersebut
        $selected_vendor = null;
        if ($user->vendor) {
            $selected_vendor = $user->vendor;
        }

        return view('pages.penawaran.form', compact('perbandingan', 'vendors', 'selected_vendor'));
    }

    public function simpanPenawaran(Request $request, PerbandinganHarga $perbandingan)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('create penawaran-pengajuan')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $request->validate([
            'vendor' => 'required|exists:vendor,id',
            'ketentuan_pembayaran' => 'required',
            'harga_satuan.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Cek jika vendor sudah memberikan penawaran untuk perbandingan ini
            $existing = PerbandinganHargaVendor::where('perbandingan_id', $perbandingan->id)
                ->where('vendor_id', $request->vendor)
                ->first();

            if ($existing) {
                return back()->with('error', 'Vendor sudah memberikan penawaran untuk perbandingan harga ini');
            }

            // Buat penawaran baru
            $vendor_penawaran = new PerbandinganHargaVendor();
            $vendor_penawaran->perbandingan_id = $perbandingan->id;
            $vendor_penawaran->vendor_id = $request->vendor;
            $vendor_penawaran->ketentuan_pembayaran = $request->ketentuan_pembayaran;
            $vendor_penawaran->diproses = true; // Tandai sudah diproses
            $vendor_penawaran->save();

            // Simpan detail harga barang
            foreach ($request->harga_satuan as $pengajuan_detail_id => $harga) {
                $pengajuan_detail = $perbandingan->pengajuan->pengajuanDetail()
                    ->where('id', $pengajuan_detail_id)
                    ->first();

                if ($pengajuan_detail) {
                    $item_barang = new PerbandinganHargaItemBarang();
                    $item_barang->perbandingan_harga_vendor_id = $vendor_penawaran->id;
                    $item_barang->pengajuan_detail_id = $pengajuan_detail_id;
                    $item_barang->nama_barang = $pengajuan_detail->nama_barang;
                    $item_barang->jumlah = $pengajuan_detail->jumlah;
                    $item_barang->harga_satuan = $harga;
                    $item_barang->save();
                }
            }

            DB::commit();

            return redirect()->route('penawaran.index')->with('success', 'Penawaran harga berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan penawaran: ' . $th->getMessage());
        }
    }

    public function editPenawaran(PerbandinganHargaVendor $perbandingan_vendor)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('update penawaran-pengajuan')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        // Cek jika perbandingan sudah selesai
        if ($perbandingan_vendor->perbandinganHarga->selesai) {
            return redirect()->route('penawaran.index')->with('error', 'Perbandingan harga sudah ditandai selesai');
        }

        // Jika user adalah vendor, cek jika penawaran milik vendor tersebut
        if ($user->vendor && $user->vendor->id != $perbandingan_vendor->vendor_id) {
            return redirect()->route('penawaran.index')->with('error', 'Anda tidak memiliki akses untuk mengedit penawaran ini');
        }

        return view('pages.penawaran.edit', compact('perbandingan_vendor'));
    }

    public function updatePenawaran(Request $request, PerbandinganHargaVendor $perbandingan_vendor)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('update penawaran-pengajuan')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $request->validate([
            'ketentuan_pembayaran' => 'required',
            'harga_satuan.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Update ketentuan pembayaran
            $perbandingan_vendor->ketentuan_pembayaran = $request->ketentuan_pembayaran;
            $perbandingan_vendor->save();

            // Update harga barang
            foreach ($request->harga_satuan as $item_id => $harga) {
                $item_barang = PerbandinganHargaItemBarang::find($item_id);
                if ($item_barang && $item_barang->perbandingan_harga_vendor_id == $perbandingan_vendor->id) {
                    $item_barang->harga_satuan = $harga;
                    $item_barang->save();
                }
            }

            DB::commit();

            return redirect()->route('perbandingan-harga.list-vendor', $perbandingan_vendor->perbandingan_id)
                ->with('success', 'Penawaran harga berhasil diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui penawaran: ' . $th->getMessage());
        }
    }

    public function hapusPenawaran(PerbandinganHargaVendor $perbandingan_vendor)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('delete penawaran-pengajuan')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        // Cek jika perbandingan sudah selesai
        if ($perbandingan_vendor->perbandinganHarga->selesai) {
            return redirect()->route('penawaran.index')->with('error', 'Perbandingan harga sudah ditandai selesai');
        }

        // Jika user adalah vendor, cek jika penawaran milik vendor tersebut
        if ($user->vendor && $user->vendor->id != $perbandingan_vendor->vendor_id) {
            return redirect()->route('penawaran.index')->with('error', 'Anda tidak memiliki akses untuk menghapus penawaran ini');
        }

        DB::beginTransaction();
        try {
            // Hapus item barang
            PerbandinganHargaItemBarang::where('perbandingan_harga_vendor_id', $perbandingan_vendor->id)->delete();
            
            // Hapus penawaran vendor
            $perbandingan_vendor->delete();

            DB::commit();

            return redirect()->route('perbandingan-harga.list-vendor', $perbandingan_vendor->perbandingan_id)
                ->with('success', 'Penawaran harga berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus penawaran: ' . $th->getMessage());
        }
    }

    public function detailPenawaran(PerbandinganHarga $perbandingan)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->cannot('read penawaran-pengajuan')) {
            return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
        }

        $perbandingan->load(['perbandinganHargaVendor.vendor', 'perbandinganHargaVendor.perbandinganHargaItemBarang', 'pengajuan.pengajuanDetail']);

        // Jika user adalah vendor, cek akses
        if ($user->vendor) {
            $vendor_access = false;
            foreach ($perbandingan->perbandinganHargaVendor as $vendor) {
                if ($vendor->vendor_id == $user->vendor->id) {
                    $vendor_access = true;
                    break;
                }
            }

            if (!$vendor_access) {
                // Cek apakah vendor ini bisa memberikan penawaran
                if ($perbandingan->selesai) {
                    return redirect()->route('penawaran.index')->with('error', 'Perbandingan harga sudah ditandai selesai');
                }
            }
        }

        $list_vendor = [];
        foreach ($perbandingan->perbandinganHargaVendor as $vendor) {
            $barang = [];
            foreach ($vendor->perbandinganHargaItemBarang as $item) {
                $barang[$item->pengajuan_detail_id] = [
                    'harga_satuan' => $item->harga_satuan,
                    'total_harga' => $item->harga_satuan * $item->jumlah,
                    'pemesanan' => $item->pemesanan,
                ];
            }
            $list_vendor[$vendor->vendor->nama] = $barang;
        }

        return view('pages.penawaran.detail', compact('perbandingan', 'list_vendor'));
    }
}