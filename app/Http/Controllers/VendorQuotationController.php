<?php

namespace App\Http\Controllers;

use App\Models\Rfq;
use App\Models\RfqVendor;
use App\Models\VendorQuotation;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VendorQuotationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:vendor_rekanan']);
    //     $this->middleware('permission:read penawaran-pengajuan')->only(['index', 'show']);
    //     $this->middleware('permission:create penawaran-pengajuan')->only(['create', 'store', 'accept', 'reject']);
    //     $this->middleware('permission:update penawaran-pengajuan')->only(['edit', 'update']);
    // }

    /**
     * Display a listing of RFQs for vendor
     */
    public function index()
    {
        $vendor = $this->getCurrentVendor();
        
        if (!$vendor) {
            return redirect()->route('login')
                           ->with('error', 'Vendor tidak ditemukan');
        }

        $rfqVendors = RfqVendor::with(['rfq.pengajuanPembelianBarang', 'vendor'])
                              ->where('vendor_id', $vendor->id)
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        return view('vendor.rfq.index', compact('rfqVendors'));
    }

    /**
     * Display the specified RFQ for vendor
     */
    public function show(RfqVendor $rfqVendor)
    {
        $this->authorize('view', $rfqVendor);

        $rfqVendor->load([
            'rfq.pengajuanPembelianBarang.details.barang',
            'quotations.pengajuanPembelianBarangDetail.barang'
        ]);

        return view('vendor.rfq.show', compact('rfqVendor'));
    }

    /**
     * Accept RFQ
     */
    public function accept(RfqVendor $rfqVendor)
    {
        $this->authorize('update', $rfqVendor);

        if ($rfqVendor->status !== RfqVendor::STATUS_DITAWARKAN) {
            return redirect()->route('vendor.rfq.show', $rfqVendor)
                           ->with('error', 'RFQ sudah direspon sebelumnya');
        }

        if (!$rfqVendor->rfq->isActive()) {
            return redirect()->route('vendor.rfq.show', $rfqVendor)
                           ->with('error', 'RFQ sudah tidak aktif');
        }

        $rfqVendor->update([
            'status' => RfqVendor::STATUS_DITERIMA,
            'responded_at' => now()
        ]);

        return redirect()->route('vendor.rfq.show', $rfqVendor)
                       ->with('success', 'RFQ berhasil diterima. Silakan ajukan penawaran harga.');
    }

    /**
     * Reject RFQ
     */
    public function reject(Request $request, RfqVendor $rfqVendor)
    {
        $this->authorize('update', $rfqVendor);

        if ($rfqVendor->status !== RfqVendor::STATUS_DITAWARKAN) {
            return redirect()->route('vendor.rfq.show', $rfqVendor)
                           ->with('error', 'RFQ sudah direspon sebelumnya');
        }

        $request->validate([
            'reject_reason' => 'required|string|max:500'
        ]);

        $rfqVendor->update([
            'status' => RfqVendor::STATUS_DITOLAK,
            'responded_at' => now(),
            'reject_reason' => $request->reject_reason
        ]);

        return redirect()->route('vendor.rfq.index')
                       ->with('success', 'RFQ berhasil ditolak');
    }

    /**
     * Show the form for creating quotation
     */
    public function create(RfqVendor $rfqVendor)
    {
        $this->authorize('update', $rfqVendor);

        if (!$rfqVendor->canSubmitQuotation()) {
            return redirect()->route('vendor.rfq.show', $rfqVendor)
                           ->with('error', 'Tidak dapat mengajukan penawaran saat ini');
        }

        $rfqVendor->load([
            'rfq.pengajuanPembelianBarang.details.barang',
            'quotations'
        ]);

        // Cek apakah sudah ada quotation
        $existingQuotations = [];
        if ($rfqVendor->hasSubmittedQuotation()) {
            foreach ($rfqVendor->quotations as $quotation) {
                $existingQuotations[$quotation->pengajuan_pembelian_barang_detail_id] = $quotation;
            }
        }

        return view('vendor.rfq.create-quotation', compact('rfqVendor', 'existingQuotations'));
    }

    /**
     * Store vendor quotation
     */
    public function store(Request $request, RfqVendor $rfqVendor)
    {
        $this->authorize('update', $rfqVendor);

        if (!$rfqVendor->canSubmitQuotation()) {
            return redirect()->route('vendor.rfq.show', $rfqVendor)
                           ->with('error', 'Tidak dapat mengajukan penawaran saat ini');
        }

        $request->validate([
            'quotations' => 'required|array',
            'quotations.*.unit_price' => 'required|numeric|min:0',
            'quotations.*.payment_terms' => 'required|string|max:500',
            'quotations.*.notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->quotations as $detailId => $quotationData) {
                // Cek apakah detail ini valid
                $detail = $rfqVendor->rfq->pengajuanPembelianBarang
                                        ->details()
                                        ->where('id', $detailId)
                                        ->first();
                
                if (!$detail) {
                    continue;
                }

                $totalPrice = $quotationData['unit_price'] * $detail->qty;

                // Update or create quotation
                VendorQuotation::updateOrCreate(
                    [
                        'rfq_vendor_id' => $rfqVendor->id,
                        'pengajuan_pembelian_barang_detail_id' => $detailId
                    ],
                    [
                        'unit_price' => $quotationData['unit_price'],
                        'total_price' => $totalPrice,
                        'payment_terms' => $quotationData['payment_terms'],
                        'notes' => $quotationData['notes'] ?? null
                    ]
                );
            }

            DB::commit();

            return redirect()->route('vendor.rfq.show', $rfqVendor)
                           ->with('success', 'Penawaran harga berhasil diajukan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                        ->with('error', 'Gagal mengajukan penawaran: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing quotation
     */
    public function edit(RfqVendor $rfqVendor)
    {
        return $this->create($rfqVendor);
    }

    /**
     * Update vendor quotation
     */
    public function update(Request $request, RfqVendor $rfqVendor)
    {
        return $this->store($request, $rfqVendor);
    }

    /**
     * Get current vendor based on logged user
     */
    private function getCurrentVendor()
    {
        $user = Auth::user();
        
        // Asumsi: user vendor memiliki relasi dengan vendor
        // Sesuaikan dengan struktur database Anda
        return Vendor::where('user_id', $user->id)->first() ?? 
               Vendor::where('email', $user->email)->first();
    }

    /**
     * Authorization check
     */
    private function authorize($action, RfqVendor $rfqVendor)
    {
        $vendor = $this->getCurrentVendor();
        
        if (!$vendor || $rfqVendor->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}