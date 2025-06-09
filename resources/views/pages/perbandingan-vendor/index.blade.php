<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Undangan Penawaran
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">Nomor</th>
                            <th class="px-4 py-2">Judul</th>
                            <th class="px-4 py-2">Batas Waktu</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list_penawaran as $penawaran)
                            @php $vendorInfo = $penawaran->perbandinganHargaVendor->first(); @endphp
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $penawaran->nomor }}</td>
                                <td class="px-4 py-2">{{ $penawaran->judul }}</td>
                                <td class="px-4 py-2">
                                    {{ optional($vendorInfo)->batas_waktu_penawaran 
                                        ? \Carbon\Carbon::parse($vendorInfo->batas_waktu_penawaran)->translatedFormat('d F Y H:i') 
                                        : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    @switch(optional($vendorInfo)->status_penawaran)
                                        @case('pending')
                                            <span class="text-yellow-600 font-semibold">Menunggu Konfirmasi</span>
                                            @break
                                        @case('disetujui')
                                            <span class="text-green-600 font-semibold">Disetujui</span>
                                            @break
                                        @case('ditolak')
                                            <span class="text-red-600 font-semibold">Ditolak</span>
                                            @break
                                        @case('berakhir')
                                            <span class="text-gray-600 font-semibold">Berakhir</span>
                                            @break
                                        @default
                                            <span class="text-gray-400 italic">Tidak diketahui</span>
                                    @endswitch
                                </td>
                               <td class="px-4 py-2">
                                    @if(optional($vendorInfo)->status_penawaran === 'pending')
                                        <a href="{{ route('perbandingan-harga.konfirmasi-undangan', $vendorInfo->id) }}" class="text-blue-600 hover:underline">Konfirmasi</a>

                                    @elseif(optional($vendorInfo)->status_penawaran === 'disetujui')
                                        @php
                                            $hargaTerisi = $vendorInfo->hargaBarangIndexed->isNotEmpty();
                                        @endphp

                                        @if($penawaran->selesai)
                                            <a href="{{ route('perbandingan-harga.list-vendor', $penawaran->id) }}" class="text-indigo-600 hover:underline">Detail</a>
                                        @elseif($hargaTerisi && $vendorInfo->ketentuan_pembayaran)
                                            <a href="{{ route('perbandingan-harga.edit-vendor', $vendorInfo->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                            <form action="{{ route('perbandingan-harga.delete-vendor', $vendorInfo->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan penawaran ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Batalkan</button>
                                            </form>
                                        @else
                                            <a href="{{ route('perbandingan-harga.isi-harga', $vendorInfo->id) }}" class="text-blue-600 hover:underline">Isi Penawaran</a>
                                        @endif

                                    @else
                                        <span class="text-gray-400 italic">Tidak Ada Aksi</span>
                                    @endif
                                </td>   
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Tidak ada undangan penawaran untuk Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $list_penawaran->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
