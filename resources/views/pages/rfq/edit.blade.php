{{-- resources/views/pages/rfq/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit RFQ: {{ $rfq->rfq_number }}
            </h2>
            <a href="{{ route('admin.rfq.show', $rfq) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <form action="{{ route('admin.rfq.update', $rfq) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Judul RFQ <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $rfq->title) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
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
                                  class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Masukkan deskripsi RFQ...">{{ old('description', $rfq->description) }}</textarea>
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
                               value="{{ old('deadline', $rfq->deadline->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
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
                                           {{ in_array($vendor->id, old('vendor_ids', $selectedVendorIds)) ? 'checked' : '' }}>
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
                        <a href="{{ route('admin.rfq.show', $rfq) }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update RFQ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>