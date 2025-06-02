<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BarangImport implements ToArray, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $data = [];

    public function array(array $array): array
    {
        $this->data = $array;
        return $array;
    }

    public function getData()
    {
        return $this->data;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:1',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_barang.required' => 'Nama barang tidak boleh kosong pada baris :row',
            'nama_barang.string' => 'Nama barang harus berupa teks pada baris :row',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter pada baris :row',
            'spesifikasi.required' => 'Spesifikasi tidak boleh kosong pada baris :row',
            'spesifikasi.string' => 'Spesifikasi harus berupa teks pada baris :row',
            'jumlah.required' => 'Jumlah tidak boleh kosong pada baris :row',
            'jumlah.integer' => 'Jumlah harus berupa angka pada baris :row',
            'jumlah.min' => 'Jumlah minimal 1 pada baris :row',
            'harga_satuan.required' => 'Harga satuan tidak boleh kosong pada baris :row',
            'harga_satuan.integer' => 'Harga satuan harus berupa angka pada baris :row',
            'harga_satuan.min' => 'Harga satuan minimal 1 pada baris :row',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}