<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRfqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update penawaran-pengajuan') && 
               $this->route('rfq')->canBeEdited();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'deadline' => 'required|date|after:now',
            'vendor_ids' => 'required|array|min:1|max:10',
            'vendor_ids.*' => 'exists:vendors,id'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul RFQ wajib diisi',
            'title.max' => 'Judul RFQ maksimal 255 karakter',
            'deadline.required' => 'Batas waktu wajib diisi',
            'deadline.after' => 'Batas waktu harus di masa depan',
            'vendor_ids.required' => 'Minimal pilih 1 vendor',
            'vendor_ids.min' => 'Minimal pilih 1 vendor',
            'vendor_ids.max' => 'Maksimal pilih 10 vendor',
        ];
    }
}