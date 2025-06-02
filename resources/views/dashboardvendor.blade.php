<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Vendor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Selamat datang, ") . Auth::guard('vendor')->user()->name . "!" }}
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-2">Informasi Akun</h3>
                        <ul class="text-sm">
                            <li><strong>Nama:</strong> {{ Auth::guard('vendor')->user()->name }}</li>
                            <li><strong>Email:</strong> {{ Auth::guard('vendor')->user()->email }}</li>
                            {{-- Tambahkan info lain sesuai kolom pada tabel vendor --}}
                        </ul>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-2">Aktivitas Terbaru</h3>
                        <p class="text-sm text-gray-300">Belum ada aktivitas terbaru.</p>
                        {{-- Bisa diganti jadi daftar penawaran, status pengajuan, dll --}}
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('vendor.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Kelola Data Vendor
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
