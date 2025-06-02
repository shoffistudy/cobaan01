<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Pengajuan Pembelian Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    <div>
                        <a href="{{ route('pengajuan-pembelian-barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Kembali
                        </a>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="text-sm text-left rtl:text-right">
                            <tr>
                                <th class="py-3 px-4">Nomor</th>
                                <td>: {{ $pengajuan->nomor }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Nama Pengajuan</th>
                                <td>: {{ $pengajuan->nama_pengajuan }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">User Input</th>
                                <td>: {{ $pengajuan->user->name }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Tanggal Input</th>
                                <td>: {{ $pengajuan->tanggal }}</td>
                            </tr>
                            @if ($pengajuan->batal)
                                <tr>
                                    <th class="py-3 px-4">Status</th>
                                    <td>: <span class="text-red-600">Dibatalkan</span></td>
                                </tr>
                                <tr>
                                    <th class="py-3 px-4">Tanggal Batal</th>
                                    <td>: {{ $pengajuan->tanggal_batal }}</td>
                                </tr>
                                <tr>
                                    <th class="py-3 px-4">Alasan Batal</th>
                                    <td>: {{ $pengajuan->keterangan_batal }}</td>
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
                                            Spesifikasi
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Harga Satuan
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Perbandingan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengajuan->detail as $barang)
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                                            <td class="px-6 py-4">{{ $barang->spesifikasi }}</td>
                                            <td class="px-6 py-4">{{ $barang->jumlah }}</td>
                                            <td class="px-6 py-4">{{ number_format($barang->harga_satuan) }}</td>
                                            <td class="px-6 py-4">{{ number_format($barang->jumlah * $barang->harga_satuan) }}</td>
                                            <td class="px-6 py-4">
                                                @if ($barang->perbandingan)
                                                    <span class="text-green-600">Sudah</span>
                                                @else
                                                    <span class="text-red-600">Belum</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-gray-700">
                                        <th colspan="4" class="text-end font-bold px-6 py-4">Grang Total</th>
                                        <th class="px-6 py-4">{{ number_format($pengajuan->detail->sum(fn($barang) => $barang->jumlah * $barang->harga_satuan)) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if (request('ref') == 'notification' && !$pengajuan->batal)
                            <div class="px-4 pb-4">
                                <h4 class="font-bold text-lg mb-2">Buat Perbandingan</h4>
                                <form action="{{ route('perbandingan-harga.store') }}" method="post">
                                    @csrf
                                    @session('error')
                                        <div class="px-4">
                                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        </div>
                                    @endsession
                                    <div class="py-1 flex items-start gap-2">
                                        <input type="hidden" name="nomor_pengajuan" value="{{ $pengajuan->nomor }}">
                                        <div class="w-full">
                                            <x-text-input name="judul" placeholder="Judul Perbandingan" id="judul" :value="old('judul')" class="w-full p-2.5 text-sm" />
                                            @error('judul')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <x-primary-button class="py-3">Simpan</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
