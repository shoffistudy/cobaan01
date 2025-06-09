<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto px-4">
           
            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Only show vendor card to admin_logistik -->
                @if(auth()->user()->hasRole('admin_logistik'))
                <!-- Card 1 - Total Vendor -->
                <a href="{{ url('/vendor') }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-700 transition duration-200 cursor-pointer">
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold text-blue-500 uppercase mb-1">TOTAL VENDOR</div>
                                <div class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $totalVendors ?? 0 }}</div>
                            </div>
                            <div class="text-gray-300 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endif

                <!-- Show pengajuan card to admin_logistik and divisi -->
                @if(auth()->user()->hasRole(['admin_logistik', 'divisi']))
                <!-- Card 2 - Total Pengajuan -->
                <a href="{{ url('/pengajuan-pembelian-barang') }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 hover:bg-green-50 dark:hover:bg-gray-700 transition duration-200 cursor-pointer">
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold text-green-500 uppercase mb-1">TOTAL PENGAJUAN</div>
                                <div class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $totalSubmissions ?? 0 }}</div>
                            </div>
                            <div class="text-gray-300 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endif

                <!-- Show pemesanan card to admin_logistik and vendor -->
                @if(auth()->user()->hasRole(['admin_logistik', 'vendor_rekanan']))
                <!-- Card 3 - Total Pemesanan -->
                <a href="{{ url('/pemesanan-barang') }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-teal-500 hover:bg-teal-50 dark:hover:bg-gray-700 transition duration-200 cursor-pointer">
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold text-teal-500 uppercase mb-1">TOTAL PEMESANAN</div>
                                <div class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $totalOrders ?? 0 }}</div>
                            </div>
                            <div class="text-gray-300 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endif

                <!-- Show penerimaan card to admin_logistik and vendor -->
                @if(auth()->user()->hasRole(['admin_logistik', 'vendor']))
                <!-- Card 4 - Total Penerimaan -->
                <a href="{{ url('/penerimaan-barang') }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500 hover:bg-yellow-50 dark:hover:bg-gray-700 transition duration-200 cursor-pointer">
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold text-yellow-500 uppercase mb-1">TOTAL PENERIMAAN</div>
                                <div class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $totalReceipts ?? 0 }}</div>
                            </div>
                            <div class="text-gray-300 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endif

                <!-- Show barang card to admin_logistik and divisi -->
                @if(auth()->user()->hasRole(['admin_logistik', 'divisi']))
                <!-- Card 5 - Total Barang -->
                <a href="{{ url('/riwayat-barang') }}">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500 hover:bg-purple-50 dark:hover:bg-gray-700 transition duration-200 cursor-pointer">
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <div class="text-xs font-bold text-purple-500 uppercase mb-1">TOTAL BARANG</div>
                                <div class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ $totalItems ?? 0 }}</div>
                            </div>
                            <div class="text-gray-300 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
            </div>

            <!-- Main content section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('status'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('status') }}</p>
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">{{ __('Welcome to your dashboard') }}</h3>

                    <!-- Role-specific welcome message -->
                    @if(auth()->user()->hasRole('vendor'))
                        <p>Selamat datang di portal Vendor. Di sini Anda dapat mengelola penawaran, melihat pesanan aktif, dan memperbarui pengiriman barang.</p>
                    @elseif(auth()->user()->hasRole('admin_logistik'))
                        <p>Selamat datang Admin Logistik. Anda dapat mengelola vendor, pengajuan, pemesanan, dan penerimaan barang di sini.</p>
                    @elseif(auth()->user()->hasRole('divisi'))
                        <p>Selamat datang Divisi. Dari sini Anda dapat membuat pengajuan baru dan memantau status pengajuan yang telah dibuat.</p>
                    @else
                        <p>Selamat datang di dashboard. Silakan gunakan menu navigasi untuk mengakses fitur yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>