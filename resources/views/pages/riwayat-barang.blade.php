<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Barang
        </h2>
    </x-slot>

    <div class="py-4"> 
        <div class="max-w-full mx-auto px-4"> 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 h-[calc(100vh-8rem)] flex flex-col"> <!-- Added flex flex-col --> <!-- Set fixed height relative to viewport -->
                @can('read riwayat-barang')
                  <!-- Search Form dengan desain yang lebih menarik -->
                  <form method="GET" action="{{ route('riwayat-barang.index') }}" class="mb-4">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Kolom Pencarian Nama -->
                                <div class="relative">
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">Cari Barang</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Nama barang..." value="{{ request()->input('search') }}" />
                                    </div>
                                </div>
                                
                                <!-- Nomor Pengajuan -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">Nomor Pengajuan</label>
                                    <select name="nomor_pengajuan" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Semua Data</option>
                                        @foreach($nomor_pengajuan_list as $nomor)
                                            <option value="{{ $nomor }}" {{ request()->input('nomor_pengajuan') == $nomor ? 'selected' : '' }}>
                                                {{ $nomor }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Tanggal Range -->
                                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">Tanggal Mulai</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input type="date" name="start_date" class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md focus:ring-blue-500 focus:border-blue-500"
                                            value="{{ request()->input('start_date') }}" />
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-1">Tanggal Akhir</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input type="date" name="end_date" class="w-full pl-10 pr-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md focus:ring-blue-500 focus:border-blue-500"
                                            value="{{ request()->input('end_date') }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tombol Filter -->
                            <div class="flex justify-end mt-4">
                                {{-- <a href="{{ route('riwayat-barang.export', request()->query()) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md mr-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Excel
                                </a> --}}
                                <a href="{{ route('riwayat-barang.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2">
                                    <i class="fas fa-redo mr-1"></i> Reset
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Cari
                                </button>
                            </div>
                            
                        </div>
                    </form>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-height: calc(100vh - 300px); overflow-y: auto;">
                        <table class="text-sm text-left rtl:text-right w-full">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-center w-[5%]">No</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[12%]">Nama Barang</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[12%]">Spesifikasi</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[8%]">Jumlah</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[12%]">Harga Satuan</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[12%]">Total</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[15%]">Nomor Pengajuan</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[15%]">Tanggal Pengajuan</th>
                                    <th scope="col" class="px-3 py-3 text-center w-[9%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat_barang as $item)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <td class="px-3 py-4 text-center">{{ ($riwayat_barang->currentPage() - 1) * $riwayat_barang->perPage() + $loop->iteration }}</td>
                                        <td class="px-3 py-4">{{ $item->nama_barang }}</td>
                                        <td class="px-3 py-4">{{ $item->spesifikasi }}</td>
                                        <td class="px-3 py-4 text-center">{{ $item->jumlah }}</td>
                                        <td class="px-3 py-4 text-right">{{ number_format($item->harga_satuan) }}</td>
                                        <td class="px-3 py-4 text-right">{{ number_format($item->total) }}</td>
                                        <td class="px-3 py-4 text-center">{{ $item->pengajuan->nomor }}</td>
                                        <td class="px-3 py-4 text-center">{{ $item->pengajuan->tanggal ? date('d-m-Y', strtotime($item->pengajuan->tanggal)) : '-' }}</td>
                                        <td class="px-3 py-4 text-center">
                                            <!-- Button Detail -->
                                            <a href="{{ route('pengajuan-pembelian-barang.show', $item->pengajuan->id) }}" 
                                                class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Links dengan custom styling -->
                    <div class="mt-4">
                        <style>
                            .pagination .page-item.active .page-link {
                                background-color: #3b82f6; /* Blue color */
                                color: white;
                                font-weight: bold;
                                border: 2px solid #2563eb; /* Darker blue border */
                            }
                            .pagination .page-link {
                                border: 1px solid #d1d5db;
                                padding: 0.5rem 0.75rem;
                            }
                        </style>
                        {{ $riwayat_barang->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="alert alert-warning">
                        Anda tidak memiliki akses untuk melihat riwayat barang.
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>