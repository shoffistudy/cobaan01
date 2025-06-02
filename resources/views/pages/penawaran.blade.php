<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Penawaran Vendor
        </h2>
    </x-slot>

    <div class="py-4"> 
        <div class="max-w-full mx-auto px-4"> 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
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
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nomor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nomor Pengajuan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Judul
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penawaran as $perbandingan)
                                    @php
                                        $vendorSudahMenawar = false;
                                        if (auth()->user()->hasRole('vendor')) {
                                            foreach ($perbandingan->perbandinganHargaVendor as $vendor) {
                                                if ($vendor->vendor_id == auth()->user()->vendor->id) {
                                                    $vendorSudahMenawar = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $perbandingan->nomor }}
                                        </th>
                                        <td class="px-6 py-4">{{ $perbandingan->pengajuan->nomor }}</td>
                                        <td class="px-6 py-4">{{ $perbandingan->judul }}</td>
                                        <td class="px-6 py-4">{{ $perbandingan->tanggal }}</td>
                                        <td class="px-6 py-4">
                                            @if ($perbandingan->selesai)
                                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Selesai</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Proses</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('penawaran.detail', $perbandingan->id) }}" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline">Lihat Detail</a>
                                            
                                            @if (!$perbandingan->selesai)
                                                @if (auth()->user()->hasRole('vendor') && !$vendorSudahMenawar)
                                                    <a href="{{ route('penawaran.tambah', $perbandingan->id) }}" class="font-medium text-green-600 me-1 dark:text-green-500 hover:underline">Buat Penawaran</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {!! $penawaran->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>