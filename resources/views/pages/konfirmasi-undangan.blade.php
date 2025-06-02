<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Konfirmasi Undangan Penawaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
                <p class="text-gray-700 dark:text-gray-200 mb-4">
                    Anda diundang untuk mengikuti penawaran barang dengan nomor perbandingan:
                    <strong>{{ $perbandingan_harga_vendor->perbandinganHarga->nomor }}</strong>
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Batas waktu pengisian penawaran: <strong>{{ \Carbon\Carbon::parse($perbandingan_harga_vendor->batas_waktu_penawaran)->translatedFormat('d F Y H:i') }}</strong>
                </p>

                <form method="POST" action="{{ route('perbandingan-harga.proses-konfirmasi-undangan', $perbandingan_harga_vendor->id) }}" class="mt-6 flex gap-4">
                    @csrf
                    <button type="submit" name="aksi" value="setuju"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                        ✅ Setuju
                    </button>
                    <button type="submit" name="aksi" value="tolak"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">
                        ❌ Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
