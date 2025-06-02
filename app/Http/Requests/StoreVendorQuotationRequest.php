<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create penawaran-pengajuan');
    }

    public function rules(): array
    {
        return [
            'quotations' => 'required|array|min:1',
            'quotations.*.unit_price' => 'required|numeric|min:1|max:999999999',
            'quotations.*.payment_terms' => 'required|string|max:500',
            'quotations.*.notes' => 'nullable|string|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'quotations.required' => 'Minimal isi 1 penawaran harga',
            'quotations.*.unit_price.required' => 'Harga per unit wajib diisi',
            'quotations.*.unit_price.numeric' => 'Harga per unit harus berupa angka',
            'quotations.*.unit_price.min' => 'Harga per unit minimal Rp 1',
            'quotations.*.unit_price.max' => 'Harga per unit terlalu besar',
            'quotations.*.payment_terms.required' => 'Ketentuan pembayaran wajib diisi',
            'quotations.*.payment_terms.max' => 'Ketentuan pembayaran maksimal 500 karakter',
            'quotations.*.notes.max' => 'Catatan maksimal 500 karakter'
        ];
    }
}
