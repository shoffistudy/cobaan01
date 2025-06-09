<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Isi Penawaran Harga
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                {{-- Notifikasi Error --}}
                @if(session('error'))
                    <div class="mb-4 p-4 text-sm text-red-800 bg-red-50 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('perbandingan-harga.update-vendor', $perbandingan_vendor->id) }}" method="POST">
                    @csrf
                    @method('put')

                    {{-- Nama Vendor --}}
                    <div class="mb-4">
                        <x-input-label for="vendor" value="Vendor" />
                        <input id="vendor" type="text" value="{{ $perbandingan_vendor->vendor->nama }}" disabled class="bg-gray-100 dark:bg-gray-700 border border-gray-300 text-gray-700 text-sm rounded-md block w-full p-2.5" />
                    </div>

                    {{-- Ketentuan Pembayaran --}}
                    <div class="mb-4">
                        <x-input-label for="ketentuan_pembayaran" value="Ketentuan Pembayaran" />
                        <x-textarea-input name="ketentuan_pembayaran"
                            :value="$errors->has('ketentuan_pembayaran') ? old('ketentuan_pembayaran') : $perbandingan_vendor->ketentuan_pembayaran"
                            class="w-full p-2.5 text-sm" placeholder="Contoh: Pembayaran 50% di awal, 50% setelah barang diterima." />
                        @error('ketentuan_pembayaran')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tabel Barang dan Harga --}}
                    <div class="mb-6 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200 border">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-2">Nama Barang</th>
                                    <th class="px-4 py-2">Jumlah</th>
                                    <th class="px-4 py-2">Harga Satuan (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perbandingan_vendor->perbandinganHargaItemBarang as $barang)
                                    <tr class="bg-white dark:bg-gray-800 border-t">
                                        <td class="px-4 py-2 font-medium">{{ $barang->nama_barang }}</td>
                                        <td class="px-4 py-2">{{ $barang->jumlah }}</td>
                                        <td class="px-4 py-2">
                                            <x-text-input
                                                name="harga_satuan[{{ $barang->id }}]"
                                                :value="$errors->has('harga_satuan.' . $barang->id) ? old('harga_satuan.' . $barang->id) : $barang->harga_satuan"
                                                type="number"
                                                class="w-full p-2.5 text-sm"
                                                placeholder="0"
                                                min="0"
                                                step="100"
                                            />
                                            @error('harga_satuan.' . $barang->id)
                                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div>
                        <x-primary-button>Simpan Penawaran</x-primary-button>
                        <a href="{{ route('perbandingan-harga.vendor.index') }}" class="ml-4 text-sm text-gray-600 hover:underline">Kembali ke Daftar Penawaran</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
