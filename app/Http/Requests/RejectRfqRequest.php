<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectRfqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update penawaran-pengajuan');
    }

    public function rules(): array
    {
        return [
            'reject_reason' => 'required|string|min:10|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'reject_reason.required' => 'Alasan penolakan wajib diisi',
            'reject_reason.min' => 'Alasan penolakan minimal 10 karakter',
            'reject_reason.max' => 'Alasan penolakan maksimal 500 karakter'
        ];
    }
}