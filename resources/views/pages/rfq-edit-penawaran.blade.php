<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit RFQ Penawaran') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- RFQ Information -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi RFQ</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Nomor RFQ:</strong> {{ $rfq->rfq_number }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Status:</strong> 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $rfq->status === 'dibuat' ? 'bg-blue-100 text-blue-800' : 
                                   ($rfq->status === 'berlangsung' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($rfq->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Dibuat pada:</strong> {{ $rfq->created_at->format('d/m/Y H:i') }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Pengajuan:</strong> {{ $rfq->pengajuanPembelianBarang->nomor_pengajuan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pengajuan Pembelian -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Pengajuan Pembelian</h3>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Nomor:</strong> {{ $rfq->pengajuanPembelianBarang->nomor_pengajuan }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Tanggal:</strong> {{ $rfq->pengajuanPembelianBarang->tanggal_pengajuan->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Pengaju:</strong> {{ $rfq->pengajuanPembelianBarang->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Keperluan:</strong> {{ $rfq->pengajuanPembelianBarang->keperluan }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Status:</strong> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($rfq->pengajuanPembelianBarang->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Barang -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Barang</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
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
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($rfq->pengajuanPembelianBarang->details as $index => $detail)
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

        <!-- Form Edit RFQ -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Edit RFQ</h3>
                
                <form action="{{ route('rfq.update', $rfq) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Judul RFQ <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $rfq->title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-300 @enderror"
                                   placeholder="Masukkan judul RFQ"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Batas Waktu Penawaran <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" 
                                   name="deadline" 
                                   id="deadline" 
                                   value="{{ old('deadline', \Carbon\Carbon::parse($rfq->deadline)->format('Y-m-d\TH:i')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('deadline') border-red-300 @enderror"
                                   required>
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Deskripsi
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-300 @enderror"
                                  placeholder="Masukkan deskripsi atau catatan tambahan untuk RFQ">{{ old('description', $rfq->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vendor Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                            Pilih Vendor <span class="text-red-500">*</span>
                        </label>
                        @error('vendor_ids')
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                {{ $message }}
                            </div>
                        @enderror

                        @if($vendors->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($vendors as $vendor)
                                <div class="vendor-card border-2 rounded-lg p-4 cursor-pointer transition-all duration-200 hover:shadow-md 
                                    {{ in_array($vendor->id, old('vendor_ids', $selectedVendorIds)) ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-600' }}">
                                    <div class="flex items-start space-x-3">
                                        <input type="checkbox" 
                                               name="vendor_ids[]" 
                                               value="{{ $vendor->id }}" 
                                               id="vendor_{{ $vendor->id }}"
                                               class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                               {{ in_array($vendor->id, old('vendor_ids', $selectedVendorIds)) ? 'checked' : '' }}>
                                        <div class="flex-1 min-w-0">
                                            <label for="vendor_{{ $vendor->id }}" class="block text-sm font-medium text-gray-900 dark:text-gray-100 cursor-pointer">
                                                {{ $vendor->nama_vendor }}
                                            </label>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $vendor->alamat }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $vendor->telepon }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $vendor->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-4 flex gap-2">
                                <button type="button" 
                                        id="selectAll"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pilih Semua
                                </button>
                                <button type="button" 
                                        id="unselectAll"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Batal Pilih Semua
                                </button>
                            </div>
                        @else
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tidak ada vendor aktif yang tersedia. Silakan tambah vendor terlebih dahulu.
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('rfq.show', $rfq) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        @if($vendors->count() > 0)
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update RFQ
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
                // Vendor selection functionality
                const selectAllBtn = document.getElementById('selectAll');
                const unselectAllBtn = document.getElementById('unselectAll');
                const vendorCheckboxes = document.querySelectorAll('input[name="vendor_ids[]"]');
                const vendorCards = document.querySelectorAll('.vendor-card');

                // Select All functionality
                if (selectAllBtn) {
                    selectAllBtn.addEventListener('click', function() {
                        vendorCheckboxes.forEach(checkbox => {
                            checkbox.checked = true;
                            updateCardAppearance(checkbox);
                        });
                    });
                }

                // Unselect All functionality
                if (unselectAllBtn) {
                    unselectAllBtn.addEventListener('click', function() {
                        vendorCheckboxes.forEach(checkbox => {
                            checkbox.checked = false;
                            updateCardAppearance(checkbox);
                        });
                    });
                }

                // Card click functionality
                vendorCards.forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.type !== 'checkbox') {
                            const checkbox = this.querySelector('input[type="checkbox"]');
                            checkbox.checked = !checkbox.checked;
                            updateCardAppearance(checkbox);
                        }
                    });
                });

                // Checkbox change functionality
                vendorCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateCardAppearance(this);
                    });
                });

                // Function to update card appearance
                function updateCardAppearance(checkbox) {
                    const card = checkbox.closest('.vendor-card');
                    if (checkbox.checked) {
                        card.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                        card.classList.remove('border-gray-200', 'dark:border-gray-600');
                    } else {
                        card.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                        card.classList.add('border-gray-200', 'dark:border-gray-600');
                    }
                }

                // Set minimum datetime to current datetime
                const deadlineInput = document.getElementById('deadline');
                if (deadlineInput) {
                    const now = new Date();
                    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
                    deadlineInput.min = localDateTime;
                }

                // Auto-hide alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('[role="alert"]');
                    alerts.forEach(alert => {
                        if (alert.querySelector('button')) {
                            alert.style.transition = 'opacity 0.5s';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    });
                }, 5000);
            });
        </script>
    </x-slot>
</x-app-layout>