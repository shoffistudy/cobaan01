<?php

namespace App\Http\Controllers;

use App\Models\Rfq;
use App\Models\RfqVendor;
use App\Models\Vendor;
use App\Models\PerbandinganHarga;
use App\Models\PengajuanPembelianBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RfqController extends Controller
{
    
    /**
     * Display a listing of RFQs
     */
    public function index()
    {
        $rfqs = Rfq::with(['pengajuanPembelianBarang.user', 'createdBy'])
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);

        return view('pages.rfq-penawaran', compact('rfqs'));
    }

    /**
     * Show the form for creating a new RFQ
     */
    public function create(Request $request)
    {
        $pengajuanId = $request->get('pengajuan_id');
        
        if (!$pengajuanId) {
            return redirect()->route('rfq.index')
                           ->with('error', 'Pilih pengajuan terlebih dahulu');
        }

        $pengajuan = PengajuanPembelianBarang::with('details.barang')
                                           ->findOrFail($pengajuanId);

        // Cek apakah sudah ada RFQ aktif untuk pengajuan ini
        if ($pengajuan->hasActiveRfq()) {
            return redirect()->route('rfq.index')
                           ->with('error', 'Pengajuan ini sudah memiliki RFQ aktif');
        }

        $vendors = Vendor::where('status', 'aktif')->get();

        return view('pages.rfq-tambah-penawaran', compact('pengajuan', 'vendors'));
    }

    // public function create(Rfq $rfq)
    // {
    //     /**
    //      * @var \App\Models\User
    //      */
    //     //$user = auth()->user();
    //     $user = Auth::user();
    //     if ($user->cannot('create rfq')) {
    //         return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
    //     }

    //     return view('pages.rfq-tambah-penawaran', ['rfq' => $rfq]);
    // }

    // public function create(PerbandinganHarga $perbandinganHarga)
    // {
    //     /**
    //      * @var \App\Models\User
    //      */
    //     //$user = auth()->user();
    //     $user = Auth::user();
    //     if ($user->cannot('create perbandingan-harga')) {
    //         return abort(403, 'Kamu tidak memiliki hak akses ke halaman ini');
    //     }

    //     return view('pages.perbandingan-form', ['perbandingan' => $perbandinganHarga]);
    // }

    // public function cariPengajuan()
    // {
    //     $list_pengajuan = PengajuanPembelianBarang::withCount('detail')
    //         ->doesntHave('perbandingan')
    //         ->where('batal', 0)
    //         ->orWhere('id', request('id'))
    //         ->get();

    //     return view('pages.perbandingan-list-pengajuan', compact('list_pengajuan'));
    // }

    // public function pilihPengajuan(PengajuanPembelianBarang $pengajuan)
    // {
    //     $pengajuan->load('detail');
    //     return view('pages.perbandingan-data-pengajuan', compact('pengajuan'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'judul' => 'required|max:255',
    //         'nomor_pengajuan' => 'required'
    //     ]);
    //     try {
    //         $pengajuan = PengajuanPembelianBarang::where('nomor', $request->nomor_pengajuan)->first();
    //         if (!$pengajuan) {
    //             throw new \Exception("Pengajuan tidak ditemukan", 1);
    //         }

    //         PerbandinganHarga::create([
    //             'nomor' => numbering('perbandingan_harga', 'PH' . date('ym')),
    //             'judul' => $request->judul,
    //             'pengajuan_id' => $pengajuan->id,
    //             'user_id' => Auth::id() // Perbaikan
    //         ]);

    //         request()->user()->markAsReadNotificationFor($pengajuan);

    //         return redirect('perbandingan-harga')->with('success', 'Data berhasil disimpan');
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }

    /**
     * Store a newly created RFQ
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'pengajuan_pembelian_barang_id' => 'required|exists:pengajuan_pembelian_barang,id',
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'deadline' => 'required|date|after:now',
    //         'vendor_ids' => 'required|array|min:1',
    //         'vendor_ids.*' => 'exists:vendors,id'
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         // Create RFQ
    //         $rfq = Rfq::create([
    //             'rfq_number' => Rfq::generateRfqNumber(),
    //             'pengajuan_pembelian_barang_id' => $request->pengajuan_pembelian_barang_id,
    //             'created_by' => Auth::id(),
    //             'title' => $request->title,
    //             'description' => $request->description,
    //             'deadline' => $request->deadline,
    //             'status' => Rfq::STATUS_DIBUAT
    //         ]);

    //         // Attach vendors to RFQ
    //         foreach ($request->vendor_ids as $vendorId) {
    //             RfqVendor::create([
    //                 'rfq_id' => $rfq->id,
    //                 'vendor_id' => $vendorId,
    //                 'status' => RfqVendor::STATUS_DITAWARKAN
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()->route('rfq.show', $rfq)
    //                        ->with('success', 'RFQ berhasil dibuat');

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return back()->withInput()
    //                     ->with('error', 'Gagal membuat RFQ: ' . $e->getMessage());
    //     }
    // }

    /**
     * Display the specified RFQ
     */
    public function show(Rfq $rfq)
    {
        $rfq->load([
            'pengajuanPembelianBarang.details.barang',
            'rfqVendors.vendor',
            'rfqVendors.quotations.pengajuanPembelianBarangDetail.barang'
        ]);

        // Group quotations by vendor
        $vendorQuotations = [];
        foreach ($rfq->rfqVendors as $rfqVendor) {
            $vendorQuotations[$rfqVendor->vendor->id] = [
                'vendor' => $rfqVendor->vendor,
                'rfq_vendor' => $rfqVendor,
                'quotations' => $rfqVendor->quotations,
                'total_amount' => $rfqVendor->quotations->sum('total_price')
            ];
        }

        return view('pages.rfq-detail-penawaran', compact('rfq', 'vendorQuotations'));
    }

    /**
     * Show the form for editing RFQ
     */
    public function edit(Rfq $rfq)
    {
        if (!$rfq->canBeEdited()) {
            return redirect()->route('rfq.show', $rfq)
                           ->with('error', 'RFQ tidak dapat diedit');
        }

        $rfq->load('rfqVendors.vendor');
        $vendors = Vendor::where('status', 'aktif')->get();
        $selectedVendorIds = $rfq->rfqVendors->pluck('vendor_id')->toArray();

        return view('pages.rfq-edit-penawaran', compact('rfq', 'vendors', 'selectedVendorIds'));
    }

    /**
     * Update the specified RFQ
     */
    public function update(Request $request, Rfq $rfq)
    {
        if (!$rfq->canBeEdited()) {
            return redirect()->route('rfq.show', $rfq)
                           ->with('error', 'RFQ tidak dapat diedit');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:now',
            'vendor_ids' => 'required|array|min:1',
            'vendor_ids.*' => 'exists:vendors,id'
        ]);

        DB::beginTransaction();
        try {
            // Update RFQ
            $rfq->update([
                'title' => $request->title,
                'description' => $request->description,
                'deadline' => $request->deadline,
            ]);

            // Update vendor selection
            $currentVendorIds = $rfq->rfqVendors->pluck('vendor_id')->toArray();
            $newVendorIds = $request->vendor_ids;

            // Remove vendors that are no longer selected
            $vendorsToRemove = array_diff($currentVendorIds, $newVendorIds);
            if (!empty($vendorsToRemove)) {
                RfqVendor::where('rfq_id', $rfq->id)
                         ->whereIn('vendor_id', $vendorsToRemove)
                         ->delete();
            }

            // Add new vendors
            $vendorsToAdd = array_diff($newVendorIds, $currentVendorIds);
            foreach ($vendorsToAdd as $vendorId) {
                RfqVendor::create([
                    'rfq_id' => $rfq->id,
                    'vendor_id' => $vendorId,
                    'status' => RfqVendor::STATUS_DITAWARKAN
                ]);
            }

            DB::commit();

            return redirect()->route('rfq.show', $rfq)
                           ->with('success', 'RFQ berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                        ->with('error', 'Gagal mengupdate RFQ: ' . $e->getMessage());
        }
    }

    /**
     * Send RFQ to vendors (change status to berlangsung)
     */
    public function sendToVendors(Rfq $rfq)
    {
        if ($rfq->status !== Rfq::STATUS_DIBUAT) {
            return redirect()->route('rfq.show', $rfq)
                           ->with('error', 'RFQ sudah dikirim sebelumnya');
        }

        $rfq->update([
            'status' => Rfq::STATUS_BERLANGSUNG,
            'sent_at' => now()
        ]);

        return redirect()->route('rfq.show', $rfq)
                       ->with('success', 'RFQ berhasil dikirim ke vendor');
    }

    /**
     * Close RFQ
     */
    public function closeRfq(Rfq $rfq)
    {
        if ($rfq->status === Rfq::STATUS_DITUTUP) {
            return redirect()->route('rfq.show', $rfq)
                           ->with('error', 'RFQ sudah ditutup');
        }

        $rfq->update([
            'status' => Rfq::STATUS_DITUTUP,
            'closed_at' => now()
        ]);

        return redirect()->route('rfq.show', $rfq)
                       ->with('success', 'RFQ berhasil ditutup');
    }

    /**
     * Select winning quotation
     */
    public function selectQuotation(Request $request, Rfq $rfq)
    {
        $request->validate([
            'quotation_ids' => 'required|array',
            'quotation_ids.*' => 'exists:vendor_quotations,id'
        ]);

        DB::beginTransaction();
        try {
            // Reset all selections for this RFQ
            foreach ($rfq->rfqVendors as $rfqVendor) {
                $rfqVendor->quotations()->update(['is_selected' => false]);
            }

            // Set selected quotations
            foreach ($request->quotation_ids as $quotationId) {
                \App\Models\VendorQuotation::where('id', $quotationId)
                                          ->update(['is_selected' => true]);
            }

            DB::commit();

            return redirect()->route('rfq.show', $rfq)
                           ->with('success', 'Penawaran terpilih berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memilih penawaran: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified RFQ
     */
    public function destroy(Rfq $rfq)
    {
        if (!$rfq->canBeEdited()) {
            return redirect()->route('rfq.index')
                           ->with('error', 'RFQ tidak dapat dihapus');
        }

        $rfq->delete();

        return redirect()->route('rfq.index')
                       ->with('success', 'RFQ berhasil dihapus');
    }
}