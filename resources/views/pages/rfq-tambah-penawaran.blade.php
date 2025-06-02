<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Tambah RFQ Penawaran') }}
                </h2>
                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <a href="{{ route('rfq.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">RFQ Penawaran</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah RFQ</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Alert Messages -->
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-900/30 dark:text-red-300" role="alert">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-900/30 dark:text-red-300" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Informasi Pengajuan Pembelian -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Pengajuan Pembelian</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <p class="text-sm"><span class="font-medium text-gray-900 dark:text-gray-100">Nomor Pengajuan:</span> <span class="text-gray-700 dark:text-gray-300">{{ $pengajuan->nomor_pengajuan }}</span></p>
                            <p class="text-sm"><span class="font-medium text-gray-900 dark:text-gray-100">Tanggal Pengajuan:</span> <span class="text-gray-700 dark:text-gray-300">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</span></p>
                            <p class="text-sm"><span class="font-medium text-gray-900 dark:text-gray-100">Pengaju:</span> <span class="text-gray-700 dark:text-gray-300">{{ $pengajuan->user->name }}</span></p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm"><span class="font-medium text-gray-900 dark:text-gray-100">Keperluan:</span> <span class="text-gray-700 dark:text-gray-300">{{ $pengajuan->keperluan }}</span></p>
                            <p class="text-sm">
                                <span class="font-medium text-gray-900 dark:text-gray-100">Status:</span> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pengajuan->status == 'disetujui' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300' }}">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Barang -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detail Barang</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Spesifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($pengajuan->details as $index => $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $detail->barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $detail->spesifikasi ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $detail->barang->satuan }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $detail->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form RFQ -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <form action="{{ route('rfq.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="pengajuan_pembelian_barang_id" value="{{ $pengajuan->id }}">
                    
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi RFQ</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul RFQ <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Masukkan judul RFQ" required
                                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-300 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Batas Waktu Penawaran <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline') }}" required
                                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('deadline') border-red-300 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" 
                                  placeholder="Masukkan deskripsi atau catatan tambahan untuk RFQ"
                                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Vendor -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Pilih Vendor <span class="text-red-500">*</span>
                        </h3>
                        @error('vendor_ids')
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-900/30 dark:text-red-300 mb-4">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @if($vendors->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($vendors as $vendor)
                                <div class="vendor-card border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-all duration-200 cursor-pointer hover:-translate-y-1">
                                    <div class="flex items-start space-x-3">
                                        <input type="checkbox" id="vendor_{{ $vendor->id }}" name="vendor_ids[]" value="{{ $vendor->id }}"
                                               {{ in_array($vendor->id, old('vendor_ids', [])) ? 'checked' : '' }}
                                               class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <label for="vendor_{{ $vendor->id }}" class="flex-1 cursor-pointer">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $vendor->nama_vendor }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $vendor->alamat }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $vendor->telepon }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $vendor->email }}</p>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 flex space-x-2">
                                <button type="button" id="selectAll" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Pilih Semua
                                </button>
                                <button type="button" id="unselectAll" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Batal Pilih Semua
                                </button>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg dark:bg-yellow-900/20 dark:border-yellow-900/30 dark:text-yellow-300">
                                Tidak ada vendor aktif yang tersedia. Silakan tambah vendor terlebih dahulu.
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-6">
                        <a href="{{ route('rfq.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Kembali
                        </a>
                        @if($vendors->count() > 0)
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan RFQ
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select All / Unselect All functionality
            const selectAllBtn = document.getElementById('selectAll');
            const unselectAllBtn = document.getElementById('unselectAll');
            const vendorCheckboxes = document.querySelectorAll('input[name="vendor_ids[]"]');

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    vendorCheckboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                });
            }

            if (unselectAllBtn) {
                unselectAllBtn.addEventListener('click', function() {
                    vendorCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                });
            }

            // Set minimum datetime to current datetime
            const deadlineInput = document.getElementById('deadline');
            if (deadlineInput) {
                const now = new Date();
                const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
                deadlineInput.min = localDateTime;
            }

            // Vendor card click functionality
            document.querySelectorAll('.vendor-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('input[type="checkbox"]');
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });
        });
        </script>
    </x-slot>
</x-app-layout>