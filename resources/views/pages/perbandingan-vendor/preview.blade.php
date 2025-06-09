<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Preview Penawaran Harga
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <div class="mb-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Nomor:</strong> {{ $perbandingan_vendor->perbandinganHarga->nomor }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Judul:</strong> {{ $perbandingan_vendor->perbandinganHarga->judul }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Vendor:</strong> {{ $perbandingan_vendor->vendor->nama }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Ketentuan Pembayaran:</strong><br>{{ $perbandingan_vendor->ketentuan_pembayaran ?? '-' }}</p>
                </div>

                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">Harga Satuan</th>
                            <th class="px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perbandingan_vendor->perbandinganHargaItemBarang as $barang)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $barang->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $barang->jumlah }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($barang->harga_satuan) }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($barang->jumlah * $barang->harga_satuan) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('vendor.penawaran.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke Daftar Penawaran</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
