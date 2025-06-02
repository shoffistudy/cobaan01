<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Penerimaan Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    <div>
                        <a href="{{ route('penerimaan-barang.index') }}"
                           class="inline-flex items-center px-4 py-2
                           bg-gray-800 dark:bg-gray-200 border
                           border-transparent rounded-md font-semibold
                           text-xs text-white dark:text-gray-800
                           uppercase tracking-widest hover:bg-gray-700
                           dark:hover:bg-white focus:bg-gray-700
                           dark:focus:bg-white active:bg-gray-900
                           dark:active:bg-gray-300 focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                           dark:focus:ring-offset-gray-800 transition
                           ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="text-sm text-left rtl:text-right">
                            <tr>
                                <th class="py-3 px-4">Nomor</th>
                                <td>: {{ $penerimaan->nomor }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Tanggal Penerimaan</th>
                                <td>: {{ $penerimaan->tanggal_penerimaan }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Nomor Pemesanan</th>
                                <td>: {{ $penerimaan->pemesanan->nomor }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Vendor</th>
                                <td>: {{ $penerimaan->vendor->nama }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Pengantar</th>
                                <td>: {{ $penerimaan->pengantar }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Penerima</th>
                                <td>: {{ $penerimaan->penerima }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">User Input</th>
                                <td>: {{ $penerimaan->user->name }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Tanggal Input</th>
                                <td>: {{ $penerimaan->tanggal }}</td>
                            </tr>
                            @if ($penerimaan->batal)
                                <tr>
                                    <th class="py-3 px-4">Status</th>
                                    <td>: <span class="text-red-600">Dibatalkan</span></td>
                                </tr>
                                <tr>
                                    <th class="py-3 px-4">Tanggal Batal</th>
                                    <td>: {{ $penerimaan->tanggal_batal }}</td>
                                </tr>
                                <tr>
                                    <th class="py-3 px-4">Alasan Batal</th>
                                    <td>: {{ $penerimaan->keterangan_batal }}</td>
                                </tr>
                            @endif
                        </table>
                        <div class="px-4">
                            <h4 class="font-bold text-lg mb-2">List Barang</h4>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Nama Barang
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Keterangan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penerimaan->detail as $barang)
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                                            <td class="px-6 py-4">{{ $barang->jumlah }}</td>
                                            <td class="px-6 py-4">{{ $barang->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
