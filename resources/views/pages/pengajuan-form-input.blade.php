<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Pengajuan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-4">
                <div class="flex flex-col gap-2">
                    @session('error')
                        <div class="px-4">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endsession
                    
                    <!-- Excel Upload Section -->
                    <div class="px-4 mb-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-3">Import Data dari Excel</h3>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1">
                                    <a href="{{ route('pengajuan-pembelian-barang.download-template') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-md transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Template Excel
                                    </a>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <input type="file" id="excel-file" accept=".xlsx,.xls" 
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <button type="button" id="upload-excel" 
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-md transition duration-150 ease-in-out">
                                            Upload
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="upload-result" class="mt-3 hidden"></div>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto pt-4">
                        <form class="max-w-4xl mx-auto" id="form" method="POST" action="{{ route('pengajuan-pembelian-barang.store') }}">
                            @csrf
                            <div class="py-1">
                                <x-input-label for="nama_pengajuan" value="Nama Pengajuan" />
                                <x-text-input name="nama_pengajuan" id="nama_pengajuan" placeholder="Nama Pengajuan" :value="old('nama_pengajuan')" class="w-full p-2.5 text-sm" />
                                @error('nama_pengajuan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>                            
                            <div class="py-1">
                                <x-input-label for="keterangan" value="Divisi" />
                                <select name="keterangan" id="keterangan" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-2.5 text-sm">
                                    <option value="">Pilih Divisi</option>
                                    <option value="Divisi Produksi KA" {{ old('keterangan') == 'Divisi Produksi KA' ? 'selected' : '' }}>Divisi Produksi KA</option>
                                    <option value="Divisi Produksi Komponen" {{ old('keterangan') == 'Divisi Produksi Komponen' ? 'selected' : '' }}>Divisi Produksi Komponen</option>
                                    <option value="Divisi Perencanaan dan Pengendalian Produksi" {{ old('keterangan') == 'Divisi Perencanaan dan Pengendalian Produksi' ? 'selected' : '' }}>Divisi Perencanaan dan Pengendalian Produksi</option>
                                    <option value="Divisi Komersial" {{ old('keterangan') == 'Divisi Komersial' ? 'selected' : '' }}>Divisi Komersial</option>
                                    <option value="Divisi Teknologi" {{ old('keterangan') == 'Divisi Teknologi' ? 'selected' : '' }}>Divisi Teknologi</option>
                                    <option value="Divisi Logistik" {{ old('keterangan') == 'Divisi Logistik' ? 'selected' : '' }}>Divisi Logistik</option>
                                    <option value="Divisi Pengendalian Kualitas" {{ old('keterangan') == 'Divisi Pengendalian Kualitas' ? 'selected' : '' }}>Divisi Pengendalian Kualitas</option>
                                </select>
                                @error('keterangan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <hr>
                            <div class="flex justify-between items-center mt-1">
                                <h4 class="font-bold">List Barang</h4>
                                <button type="button" id="clear-all" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Hapus Semua Data
                                </button>
                            </div>
                            <input type="hidden" name="jumlah_list" id="jumlah-list" value="{{ old('jumlah_list') ?? 1 }}">
                            <div class="my-3 flex flex-col gap-7" id="list-barang">
                                <div class="relative border border-gray-400 rounded-lg p-2 item-barang">
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <x-input-label value="Nama Barang" />
                                            <x-text-input name="nama_barang[]" :value="old('nama_barang.0')" placeholder="Nama Barang" class="w-full p-2.5 text-sm" />
                                            @error('nama_barang.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Jumlah" />
                                            <x-text-input name="jumlah[]" type="number" :value="old('jumlah.0')" placeholder="Jumlah" class="w-full p-2.5 text-sm" />
                                            @error('jumlah.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Harga Satuan" />
                                            <x-text-input name="harga_satuan[]" type="number" :value="old('harga_satuan.0')" placeholder="Harga Satuan" class="w-full p-2.5 text-sm" />
                                            @error('harga_satuan.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div>
                                            <x-input-label value="Spesifikasi" />
                                            <x-textarea-input name="spesifikasi[]" :value="old('spesifikasi.0')" placeholder="Spesifikasi" class="w-full p-2.5 text-sm" />
                                            @error('spesifikasi.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if (old('jumlah_list'))
                                    @for ($i = 1; $i < old('jumlah_list'); $i++)
                                        <div class="relative border border-gray-400 rounded-lg p-2 item-barang">
                                            <x-primary-button type="button" class="delete font-medium absolute -right-5 -top-5 !bg-red-700 !rounded-full !text-sm !p-2.5 !text-center inline-flex items-center me-2">
                                                <svg class="w-[14px] h-[14px] text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="sr-only">Icon description</span>
                                            </x-primary-button>
                                            <div class="grid grid-cols-3 gap-2">
                                                <div>
                                                    <x-input-label value="Nama Barang" />
                                                    <x-text-input name="nama_barang[]" :value="old('nama_barang.' . $i)" placeholder="Nama Barang" class="w-full p-2.5 text-sm" />
                                                    @error("nama_barang.$i")
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <x-input-label value="Jumlah" />
                                                    <x-text-input name="jumlah[]" type="number" :value="old('jumlah.' . $i)" placeholder="Jumlah" class="w-full p-2.5 text-sm" />
                                                    @error("jumlah.$i")
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <x-input-label value="Harga Satuan" />
                                                    <x-text-input name="harga_satuan[]" type="number" :value="old('harga_satuan.' . $i)" placeholder="Harga Satuan" class="w-full p-2.5 text-sm" />
                                                    @error("harga_satuan.$i")
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <x-input-label value="Spesifikasi" />
                                                    <x-textarea-input name="spesifikasi[]" :value="old('spesifikasi.' . $i)" placeholder="Spesifikasi" class="w-full p-2.5 text-sm" />
                                                    @error("spesifikasi.$i")
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <div class="py-1 text-right">
                                <x-primary-button type="button" id="add-barang" class="font-medium !rounded-full !text-sm !p-2.5 !text-center inline-flex items-center me-2">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                    </svg>
                                    <span class="sr-only">Icon description</span>
                                </x-primary-button>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('pengajuan-pembelian-barang.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                                <x-primary-button>Simpan</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden" id="copy-form">
        <div class="relative border border-gray-400 rounded-lg p-2 item-barang">
            <x-primary-button type="button" class="delete font-medium absolute -right-5 -top-5 !bg-red-700 !rounded-full !text-sm !p-2.5 !text-center inline-flex items-center me-2">
                <svg class="w-[14px] h-[14px] text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Icon description</span>
            </x-primary-button>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <x-input-label value="Nama Barang" />
                    <x-text-input name="nama_barang[]" placeholder="Nama Barang" class="w-full p-2.5 text-sm" />
                </div>
                <div>
                    <x-input-label value="Jumlah" />
                    <x-text-input name="jumlah[]" type="number" placeholder="Jumlah" class="w-full p-2.5 text-sm" />
                </div>
                <div>
                    <x-input-label value="Harga Satuan" />
                    <x-text-input name="harga_satuan[]" type="number" placeholder="Harga Satuan" class="w-full p-2.5 text-sm" />
                </div>
            </div>
            <div class="mt-2">
                <div>
                    <x-input-label value="Spesifikasi" />
                    <x-textarea-input name="spesifikasi[]" placeholder="Spesifikasi" class="w-full p-2.5 text-sm" />
                </div>
            </div>
        </div>
    </div>

    <x-slot:js>
        <script>
            'use strict'

            var pengajuanJs = function() {
                const addButton = document.getElementById('add-barang')
                const uploadButton = document.getElementById('upload-excel')
                const excelFileInput = document.getElementById('excel-file')
                const clearAllButton = document.getElementById('clear-all')

                // Existing add button functionality
                addButton.addEventListener('click', function(e) {
                    let jumlahList = document.getElementById('jumlah-list')
                    let formBarang = document.querySelector('#copy-form .item-barang')
                    let node = formBarang.cloneNode(true)
                    document.getElementById('list-barang').appendChild(node)
                    jumlahList.value = parseInt(jumlahList.value) + 1

                    window.scrollTo(0, document.body.scrollHeight)
                })

                // Existing delete functionality
                document.getElementById('list-barang').addEventListener('click', function(e) {
                    let target = e.target
                    let check = true
                    let jumlahList = document.getElementById('jumlah-list')

                    while (check) {
                        if (target.classList.contains('delete') || target.tagName == 'BODY') {
                            if (target.classList.contains('delete')) {
                                target.parentElement.remove()
                                jumlahList.value = parseInt(jumlahList.value) - 1
                            }
                            break;
                        } else {
                            target = target.parentElement
                        }
                    }
                })

                // Clear all data functionality
                clearAllButton.addEventListener('click', function(e) {
                    if (confirm('Apakah Anda yakin ingin menghapus semua data barang?')) {
                        clearAllItems()
                    }
                })

                // Excel upload functionality
                uploadButton.addEventListener('click', function(e) {
                    const file = excelFileInput.files[0]
                    
                    if (!file) {
                        showUploadResult('error', 'Silakan pilih file Excel terlebih dahulu')
                        return
                    }

                    const formData = new FormData()
                    formData.append('excel_file', file)

                    // Show loading
                    uploadButton.disabled = true
                    uploadButton.textContent = 'Memproses...'

                    fetch('{{ route("pengajuan-pembelian-barang.upload-excel") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            populateFormWithExcelData(data.data)
                            showUploadResult('success', data.message)
                            excelFileInput.value = '' // Clear file input
                        } else {
                            let errorMessage = data.message
                            if (data.errors && data.errors.length > 0) {
                                errorMessage += ':\n' + data.errors.join('\n')
                            }
                            showUploadResult('error', errorMessage)
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error)
                        showUploadResult('error', 'Terjadi kesalahan saat mengupload file')
                    })
                    .finally(() => {
                        uploadButton.disabled = false
                        uploadButton.textContent = 'Upload'
                    })
                })

                function populateFormWithExcelData(data) {
                    // Clear existing items first (except the first one)
                    clearAllItems()

                    const listBarang = document.getElementById('list-barang')
                    const jumlahList = document.getElementById('jumlah-list')

                    data.forEach((item, index) => {
                        let itemContainer

                        if (index === 0) {
                            // Use first existing item
                            itemContainer = listBarang.querySelector('.item-barang')
                        } else {
                            // Clone template for additional items
                            let formBarang = document.querySelector('#copy-form .item-barang')
                            itemContainer = formBarang.cloneNode(true)
                            listBarang.appendChild(itemContainer)
                        }

                        // Populate fields
                        const namaBarangInput = itemContainer.querySelector('input[name="nama_barang[]"]')
                        const jumlahInput = itemContainer.querySelector('input[name="jumlah[]"]')
                        const hargaSatuanInput = itemContainer.querySelector('input[name="harga_satuan[]"]')
                        const spesifikasiInput = itemContainer.querySelector('textarea[name="spesifikasi[]"]')

                        if (namaBarangInput) namaBarangInput.value = item.nama_barang || ''
                        if (jumlahInput) jumlahInput.value = item.jumlah || ''
                        if (hargaSatuanInput) hargaSatuanInput.value = item.harga_satuan || ''
                        if (spesifikasiInput) spesifikasiInput.value = item.spesifikasi || ''
                    })

                    jumlahList.value = data.length
                }

                function clearAllItems() {
                    const listBarang = document.getElementById('list-barang')
                    const items = listBarang.querySelectorAll('.item-barang')
                    const jumlahList = document.getElementById('jumlah-list')

                    // Remove all items except the first one
                    for (let i = 1; i < items.length; i++) {
                        items[i].remove()
                    }

                    // Clear values in the first item
                    const firstItem = items[0]
                    if (firstItem) {
                        const inputs = firstItem.querySelectorAll('input, textarea')
                        inputs.forEach(input => input.value = '')
                    }

                    jumlahList.value = 1
                }

                function showUploadResult(type, message) {
                    const resultDiv = document.getElementById('upload-result')
                    resultDiv.className = 'mt-3 p-3 rounded-md text-sm'
                    
                    if (type === 'success') {
                        resultDiv.className += ' bg-green-50 text-green-800 border border-green-200'
                    } else {
                        resultDiv.className += ' bg-red-50 text-red-800 border border-red-200'
                    }
                    
                    resultDiv.textContent = message
                    resultDiv.classList.remove('hidden')

                    // Auto hide after 5 seconds
                    setTimeout(() => {
                        resultDiv.classList.add('hidden')
                    }, 5000)
                }
            }()
        </script>
    </x-slot:js>
</x-app-layout>