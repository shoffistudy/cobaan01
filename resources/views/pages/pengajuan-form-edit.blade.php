<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Pengajuan</h2>
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
                    <div class="relative overflow-x-auto pt-4">
                        <form class="max-w-4xl mx-auto" id="form" method="POST" action="{{ $pengajuan->id ? route('pengajuan-pembelian-barang.update', $pengajuan->id) : route('pengajuan-pembelian-barang.store') }}">
                            @csrf
                            @if ($pengajuan->id)
                                @method('put')
                            @endif
                            <div class="py-1">
                                <x-input-label for="nama_pengajuan" value="Nama Pengajuan" />
                                <x-text-input name="nama_pengajuan" id="nama_pengajuan" placeholder="Nama Pengajuan" :value="$errors->has('nama_pengajuan') ? old('nama_pengajuan') : $pengajuan->nama_pengajuan" class="w-full p-2.5 text-sm" />
                                @error('nama_pengajuan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="py-1">
                                <x-input-label for="keterangan" value="Keterangan" />
                                <x-textarea-input name="keterangan" id="keterangan" placeholder="Keterangan" :value="$errors->has('keterangan') ? old('keterangan') : $pengajuan->keterangan" class="w-full p-2.5 text-sm" />
                                @error('keterangan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <hr>
                            <h4 class="font-bold mt-1">List Barang</h4>
                            @php
                                $jumlah_list = $pengajuan->detail->count();
                                $jumlah_list = $jumlah_list > 0 ? $jumlah_list : 1;
                            @endphp
                            <input type="hidden" name="jumlah_list" id="jumlah-list" value="{{ old('jumlah_list') ?? $jumlah_list }}">
                            <div class="my-3 flex flex-col gap-7" id="list-barang">
                                <div class="relative border border-gray-400 rounded-lg p-2 item-barang">
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <x-input-label value="Nama Barang" />
                                            <x-text-input name="nama_barang[]" :value="$errors->has('nama_barang.0') ? old('nama_barang.0') : $pengajuan->detail->first()?->nama_barang" placeholder="Nama Barang" class="w-full p-2.5 text-sm" />
                                            @error('nama_barang.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Jumlah" />
                                            <x-text-input name="jumlah[]" type="number" :value="$errors->has('jumlah.0') ? old('jumlah.0') : $pengajuan->detail->first()?->jumlah" placeholder="Jumlah" class="w-full p-2.5 text-sm" />
                                            @error('jumlah.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div>
                                            <x-input-label value="Harga Satuan" />
                                            <x-text-input name="harga_satuan[]" type="number" :value="$errors->has('harga_satuan.0') ? old('harga_satuan.0') : $pengajuan->detail->first()?->harga_satuan" placeholder="Harga Satuan" class="w-full p-2.5 text-sm" />
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
                                            <x-textarea-input name="spesifikasi[]" :value="$errors->has('spesifikasi') ? old('spesifikasi.0') : $pengajuan->detail->first()?->spesifikasi" placeholder="Spesifikasi" class="w-full p-2.5 text-sm" />
                                            @error('spesifikasi.0')
                                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @foreach ($pengajuan->detail as $key => $barang)
                                    @if (!$loop->first)
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
                                                    <x-text-input name="nama_barang[]" :value="$errors->has('nama_barang.' . $key) ? old('nama_barang.' . $key) : $barang->nama_barang" placeholder="Nama Barang" class="w-full p-2.5 text-sm" />
                                                    @error('nama_barang.' . $key)
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <x-input-label value="Jumlah" />
                                                    <x-text-input name="jumlah[]" type="number" :value="$errors->has('jumlah.' . $key) ? old('jumlah.' . $key) : $barang->jumlah" placeholder="Jumlah" class="w-full p-2.5 text-sm" />
                                                    @error('jumlah.' . $key)
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <x-input-label value="Harga Satuan" />
                                                    <x-text-input name="harga_satuan[]" type="number" :value="$errors->has('harga_satuan.' . $key) ? old('harga_satuan.' . $key) : $barang->harga_satuan" placeholder="Harga Satuan" class="w-full p-2.5 text-sm" />
                                                    @error('harga_satuan.' . $key)
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <x-input-label value="Spesifikasi" />
                                                    <x-textarea-input name="spesifikasi[]" :value="$errors->has('spesifikasi.' . $key) ? old('spesifikasi.' . $key) : $barang->spesifikasi" placeholder="Spesifikasi" class="w-full p-2.5 text-sm" />
                                                    @error('spesifikasi.' . $key)
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @if (old('jumlah_list'))
                                    @for ($i = $jumlah_list; $i < old('jumlah_list'); $i++)
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
                                <a href="{{ route('pengajuan-pembelian-barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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

                addButton.addEventListener('click', function(e) {
                    let jumlahList = document.getElementById('jumlah-list')
                    let formBarang = document.querySelector('#copy-form .item-barang')
                    let node = formBarang.cloneNode(true)
                    document.getElementById('list-barang').appendChild(node)
                    jumlahList.value = parseInt(jumlahList.value) + 1

                    window.scrollTo(0, document.body.scrollHeight)
                })

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
            }()
        </script>
    </x-slot:js>
</x-app-layout>
