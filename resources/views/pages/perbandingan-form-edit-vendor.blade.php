<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Harga Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    <div>
                        <a href="{{ route('perbandingan-harga.list-vendor', $perbandingan_vendor->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                    @session('error')
                        <div class="px-4">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">Error!</span> {{ session('error') }}.
                            </div>
                        </div>
                    @endsession
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                        <form action="{{ route('perbandingan-harga.update-vendor', $perbandingan_vendor->id) }}" class="w-full" method="POST">
                            @csrf
                            @method('put')
                            <div class="py-1">
                                <x-input-label for="vendor" value="Vendor" />
                                <select id="vendor" name="vendor" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>{{ $perbandingan_vendor->vendor->nama }}</option>
                                </select>
                                {{-- <input type="text" value="{{ auth()->user()->vendor->nama }}" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" /> --}}
                            </div>
                            <div class="py-1">
                                <x-input-label for="ketentuan_pembayaran" value="Ketentuan Pembayaran" />
                                <x-textarea-input name="ketentuan_pembayaran" :value="$errors->has('ketentuan_pembayaran') ? old('ketentuan_pembayaran') : $perbandingan_vendor->ketentuan_pembayaran" class="w-full p-2.5 text-sm" placeholder="Ketentuan Pembayaran" />
                                @error('ketentuan_pembayaran')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="py-1">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Barang
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Qty
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Harga Satuan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perbandingan_vendor->perbandinganHargaItemBarang as $barang)
                                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $barang->nama_barang }}
                                                </th>
                                                <td class="px-6 py-4 text-gray-900">{{ $barang->jumlah }}</td>
                                                <td class="px-6 py-4">
                                                    <x-text-input name="harga_satuan[{{ $barang->id }}]" :value="$errors->has('harga_satuan.' . $barang->id) ? old('harga_satuan.' . $barang->id) : $barang->harga_satuan" type="number" class="w-full p-2.5 text-sm" placeholder="Harga Satuan" />
                                                    @error('harga_satuan.' . $barang->id)
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-1">
                                <x-primary-button>Simpan</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
