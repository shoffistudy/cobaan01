<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Konfirmasi Undangan Penawaran
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $perbandingan_harga_vendor->perbandinganHarga->judul }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Nomor: {{ $perbandingan_harga_vendor->perbandinganHarga->nomor }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($perbandingan_harga_vendor->status_penawaran === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($perbandingan_harga_vendor->status_penawaran === 'disetujui') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($perbandingan_harga_vendor->status_penawaran === 'ditolak') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ ucfirst($perbandingan_harga_vendor->status_penawaran) }}
                        </span>
                    </div>
                </div>

                <!-- Detail -->
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Dibuat oleh:</p>
                            <p class="text-gray-900 dark:text-white">{{ $perbandingan_harga_vendor->perbandinganHarga->user->name }}</p>

                            {{-- <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Tanggal Dibuat:</p>
                            <p class="text-gray-900 dark:text-white">
                                {{ optional($perbandingan_harga_vendor->perbandinganHarga->created_at)->format('d/m/Y H:i') ?? '-' }}
                            </p> --}}
                        </div>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Batas Waktu Penawaran:</p>
                            <p class="text-gray-900 dark:text-white">{{ $perbandingan_harga_vendor->batas_waktu_penawaran?->format('d/m/Y H:i') ?? '-' }}</p>

                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">Vendor:</p>
                            <p class="text-gray-900 dark:text-white">{{ $perbandingan_harga_vendor->vendor->nama }}</p>
                        </div>
                    </div>

                    <!-- Barang -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Detail Barang</h4>
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">Nama Barang</th>
                                    <th class="px-4 py-2">Jumlah</th>
                                    <th class="px-4 py-2">Satuan</th>
                                    <th class="px-4 py-2">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($perbandingan_harga_vendor->perbandinganHarga->pengajuanDetail as $index => $detail)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $detail->nama_barang }}</td>
                                        <td class="px-4 py-2">{{ number_format($detail->jumlah) }}</td>
                                        <td class="px-4 py-2">{{ $detail->satuan }}</td>
                                        <td class="px-4 py-2">{{ $detail->keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Konfirmasi -->
                    @if($perbandingan_harga_vendor->status_penawaran === 'pending')
                        @if($perbandingan_harga_vendor->isBerakhir())
                            <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200 p-4 rounded-lg">
                                Penawaran ini sudah <strong>berakhir</strong>. Anda tidak dapat lagi memberikan respon.
                            </div>
                        @else
                            <!-- Tombol Konfirmasi -->
                            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                                <h4 class="text-lg font-semibold mb-4 text-blue-800 dark:text-blue-200">Konfirmasi Partisipasi</h4>
                                <div class="flex gap-4">
                                    <!-- Tombol Setuju -->
                                    <button onclick="document.getElementById('modalSetuju').classList.remove('hidden')" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">✅ Setuju</button>
                                    <!-- Tombol Tolak -->
                                    <button onclick="document.getElementById('modalTolak').classList.remove('hidden')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">❌ Tolak</button>
                                </div>
                            </div>
                        @endif

                        <!-- Modal Setuju -->
                        <div id="modalSetuju" class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center hidden">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow w-96">
                                <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                                <p>Apakah Anda yakin ingin <strong>MENYETUJUI</strong> undangan ini?</p>
                                <form method="POST" action="{{ route('perbandingan-harga.proses-konfirmasi-undangan', $perbandingan_harga_vendor->id) }}" class="mt-4 flex justify-end gap-3">
                                    @csrf
                                    <button type="submit" name="aksi" value="setuju" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Ya, Setuju</button>
                                    <button type="button" onclick="document.getElementById('modalSetuju').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Tolak -->
                        <div id="modalTolak" class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center hidden">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow w-96">
                                <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                                <p>Apakah Anda yakin ingin <strong>MENOLAK</strong> undangan ini? Tindakan ini tidak dapat dibatalkan.</p>
                                <form method="POST" action="{{ route('perbandingan-harga.proses-konfirmasi-undangan', $perbandingan_harga_vendor->id) }}" class="mt-4 flex justify-end gap-3">
                                    @csrf
                                    <button type="submit" name="aksi" value="tolak" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ya, Tolak</button>
                                    <button type="button" onclick="document.getElementById('modalTolak').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Kembali -->
                    <div class="mt-6">
                        <a href="{{ route('perbandingan-harga.vendor.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                            ← Kembali ke Daftar Penawaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
