<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRfqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create penawaran-pengajuan');
    }

    public function rules(): array
    {
        return [
            'pengajuan_pembelian_barang_id' => 'required|exists:pengajuan_pembelian_barang,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'deadline' => 'required|date|after:' . now()->addHours(24),
            'vendor_ids' => 'required|array|min:1|max:10',
            'vendor_ids.*' => 'exists:vendors,id'
        ];
    }

    public function messages(): array
    {
        return [
            'pengajuan_pembelian_barang_id.required' => 'Pengajuan pembelian wajib dipilih',
            'pengajuan_pembelian_barang_id.exists' => 'Pengajuan pembelian tidak valid',
            'title.required' => 'Judul RFQ wajib diisi',
            'title.max' => 'Judul RFQ maksimal 255 karakter',
            'deadline.required' => 'Batas waktu wajib diisi',
            'deadline.after' => 'Batas waktu minimal 24 jam dari sekarang',
            'vendor_ids.required' => 'Minimal pilih 1 vendor',
            'vendor_ids.min' => 'Minimal pilih 1 vendor',
            'vendor_ids.max' => 'Maksimal pilih 10 vendor',
        ];
    }
}