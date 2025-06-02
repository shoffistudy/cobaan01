<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            List Harga Dari Vendor
        </h2>
    </x-slot>

    <div class="py-4"> 
        <div class="max-w-full mx-auto px-4"> 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    <div>
                        <a href="{{ route('perbandingan-harga.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Kembali
                        </a>
                        @if (auth()->user()->can('create ' . request()->segment(1)) && !$perbandingan->selesai)
                            <a href="{{ route('perbandingan-harga.tambah-vendor', $perbandingan->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Tambah Vendor
                            </a>
                        @endif
                    </div>
                    @session('success')
                        <div>
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">Sukses!</span> {{ session('success') }}.
                            </div>
                        </div>
                    @endsession
                    @session('error')
                        <div class="px-4">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">Error!</span> {{ session('error') }}.
                            </div>
                        </div>
                    @endsession
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="text-sm text-left rtl:text-right">
                            <tr>
                                <th class="py-3 px-4">Nomor</th>
                                <td>: {{ $perbandingan->nomor }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Judul</th>
                                <td>: {{ $perbandingan->judul }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">User Input</th>
                                <td>: {{ $perbandingan->user->name }}</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-4">Tanggal Input</th>
                                <td>: {{ $perbandingan->tanggal }}</td>
                            </tr>
                        </table>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                @if (auth()->user()->can('create ' . request()->segment(1)) && !$perbandingan->selesai)
                                    <tr>
                                        <th colspan="3" scope="col" class="px-6 py-3"></th>
                                        @foreach ($perbandingan->perbandinganHargaVendor as $perbandingan_harga_vendor)
                                            <th scope="col" class="px-6 py-3">
                                                <div class="flex gap-4">
                                                    <a href="{{ route('perbandingan-harga.edit-vendor', $perbandingan_harga_vendor->id) }}" class="flex justify-between items-center">
                                                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                                                            <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-base mt-0.5 capitalize">Edit</span>
                                                    </a>
                                                    <form action="{{ route('perbandingan-harga.delete-vendor', $perbandingan_harga_vendor->id) }}" onsubmit="return confirm('Hapus perbandingan harga dari vendor ini?');" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="flex justify-between items-center">
                                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="text-base mt-0.5 capitalize">Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </th>
                                        @endforeach
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Barang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Qty
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Estimasi Harga
                                    </th>
                                    @foreach ($list_vendor as $nama_vendor => $list_barang)
                                        <th scope="col" class="px-6 py-3">
                                            {{ $nama_vendor }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perbandingan->pengajuanDetail as $barang)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $barang->nama_barang }}
                                        </th>
                                        <td class="px-6 py-4 text-gray-900">{{ $barang->jumlah }}</td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-900">{{ number_format($barang->jumlah * $barang->harga_satuan) }}</p>
                                            <span class="text-gray-400 text-xs">{{ '@' . number_format($barang->harga_satuan) }}</span>
                                        </td>
                                        @foreach ($list_vendor as $list_barang)
                                            @php
                                                $item = $list_barang[$barang->id] ?? null;
                                            @endphp
                                            <td class="px-6 py-4 {{ isset($item['pemesanan']) && $item['pemesanan'] ? 'bg-green-400/40' : '' }}">
                                                @if ($item)
                                                    <p class="text-gray-900">
                                                        {{ number_format($item['total_harga']) }}
                                                    </p>
                                                    <span class="text-gray-400 text-xs">
                                                        {{ '@' . number_format($item['harga_satuan']) }}
                                                    </span>
                                                @else
                                                    <span class="italic text-gray-400">Belum diisi</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot class="text-gray-700 bg-gray-300">
                                <th scope="col" class="px-6 py-3" colspan="3">  
                                    Ketentuan Pembayaran
                                </th>
                                @foreach ($perbandingan->perbandinganHargaVendor as $perbandingan_harga_vendor)
                                    <th scope="col" class="px-6 py-3">
                                        {{ $perbandingan_harga_vendor->ketentuan_pembayaran ?? '-' }}
                                    </th>
                                @endforeach
                            </tfoot>
                        </table>
                    </div>
                    @if (!$perbandingan->selesai && $perbandingan->perbandinganHargaVendor->count() && auth()->user()->hasRole('admin_logistik'))
                        <div>
                            <form action="{{ route('perbandingan-harga.tandai-selesai', $perbandingan->id) }}" method="POST" onsubmit="return confirm('Setelah ditandai selesai, perbandingan tidak dapat diubah?');">
                                @csrf
                                <x-primary-button>Tandai Selesai</x-primary-button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
