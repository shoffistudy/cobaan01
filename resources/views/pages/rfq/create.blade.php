{{-- resources/views/pages/rfq/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Buat RFQ Baru') }}
            </h2>
            <a href="{{ route('admin.rfq.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Alert Messages -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Create RFQ -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Form RFQ</h3>
                        
                        <form action="{{ route('admin.rfq.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pengajuan_pembelian_barang_id" value="{{ $pengajuan->id }}">

                            <div class="space-y-4">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Judul RFQ <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="title" 
                                           value="{{ old('title', 'RFQ - ' . $pengajuan->nomor_pengajuan) }}"
                                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md"
                                           required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Deskripsi
                                    </label>
                                    <textarea name="description" 
                                              id="description" 
                                              rows="4"
                                              class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md"
                                              placeholder="Masukkan deskripsi RFQ...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Deadline -->
                                <div>
                                    <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Deadline <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" 
                                           name="deadline" 
                                           id="deadline" 
                                           value="{{ old('deadline', now()->addDays(7)->format('Y-m-d\TH:i')) }}"
                                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md"
                                           required>
                                    @error('deadline')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Vendor Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        Pilih Vendor <span class="text-red-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto border dark:border-gray-600 rounded-md p-3">
                                        @forelse($vendors as $vendor)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       name="vendor_ids[]" 
                                                       value="{{ $vendor->id }}" 
                                                       id="vendor_{{ $vendor->id }}"
                                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                       {{ in_array($vendor->id, old('vendor_ids', [])) ? 'checked' : '' }}>
                                                <label for="vendor_{{ $vendor->id }}" class="ml-2 text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $vendor->nama_perusahaan }}
                                                </label>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 dark:text-gray-400">Tidak ada vendor aktif</p>
                                        @endforelse
                                    </div>
                                    @error('vendor_ids')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end space-x-3 pt-4">
                                    <a href="{{ route('admin.rfq.index') }}" 
                                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200">
                                        Batal
                                    </a>
                                    <button type="submit" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                        <i class="fas fa-save mr-2"></i>Simpan RFQ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pengajuan Details -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Detail Pengajuan</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor Pengajuan:</span>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $pengajuan->nomor_pengajuan }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Pengaju:</span>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $pengajuan->user->name ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Pengajuan:</span>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $pengajuan->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-md font-medium mb-3">Daftar Barang</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($pengajuan->details as $detail)
                                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            Jumlah: {{ $detail->jumlah }} {{ $detail->satuan }}
                                        </p>
                                        @if($detail->keterangan)
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                Ket: {{ $detail->keterangan }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>