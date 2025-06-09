<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Isi Penawaran Harga
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('perbandingan-harga.simpan-harga', $perbandingan_harga_vendor->id) }}">
                    @csrf

                    {{-- Ketentuan Pembayaran --}}
                    <div class="mb-4">
                        <x-input-label for="ketentuan_pembayaran" value="Ketentuan Pembayaran" />
                        <x-textarea-input 
                            name="ketentuan_pembayaran" 
                            class="w-full p-2.5 text-sm"
                            placeholder="Ketentuan Pembayaran"
                        >{{ old('ketentuan_pembayaran', $perbandingan_harga_vendor->ketentuan_pembayaran) }}</x-textarea-input>
                        @error('ketentuan_pembayaran')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Daftar Barang --}}
                    <div class="py-1">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Nama Barang</th>
                                    <th class="px-6 py-3">Qty</th>
                                    <th class="px-6 py-3">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perbandingan->pengajuanDetail as $barang)
                                    @php
                                        $hargaTersimpan = old('harga_satuan.' . $barang->id, $harga_satuan[$barang->id] ?? '');
                                    @endphp
                                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $barang->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-900">
                                            {{ $barang->jumlah }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input 
                                                name="harga_satuan[{{ $barang->id }}]" 
                                                :value="$hargaTersimpan"
                                                type="number" 
                                                class="w-full p-2.5 text-sm" 
                                                placeholder="Harga Satuan"
                                            />
                                            @error('harga_satuan.' . $barang->id)
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                            @enderror
                                            @if (is_numeric($hargaTersimpan))
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Estimasi Total: {{ number_format($barang->jumlah * $hargaTersimpan) }}
                                                </p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Tombol Simpan & Kembali --}}
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('perbandingan-harga.vendor.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            ← Kembali
                        </a>

                        <x-primary-button>
                            Simpan Penawaran
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
