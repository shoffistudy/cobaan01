<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Penerimaan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-4">
                <div class="flex flex-col gap-2">
                    @session('error')
                        <div class="px-4">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endsession
                    <div class="relative overflow-x-auto p-4">
                        <form class="max-w-full mx-auto" method="POST" action="{{ route('penerimaan-barang.store') }}">
                            @csrf
                            <div class="py-1">
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <x-input-label for="tanggal_penerimaan" value="Tanggal Penerimaan" />
                                        <x-text-input type="date" name="tanggal_penerimaan" id="tanggal_penerimaan" :value="old('tanggal_penerimaan')" placeholder="Tanggal Penerimaan" class="w-full p-2.5 text-sm" />
                                        @error('tanggal_penerimaan')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-input-label for="pengantar" value="Pengantar" />
                                        <x-text-input name="pengantar" id="pengantar" :value="old('pengantar')" placeholder="Pengantar" class="w-full p-2.5 text-sm" />
                                        @error('pengantar')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-input-label for="penerima" value="Penerima" />
                                        <x-text-input name="penerima" id="penerima" :value="old('penerima')" placeholder="Penerima" class="w-full p-2.5 text-sm" />
                                        @error('penerima')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="py-1">
                                <x-input-label for="nomor_pemesanan" value="Nomor Pemesanan" />
                                <div class="relative w-full">
                                    <x-text-input name="nomor_pemesanan" id="nomor_pemesanan" :value="old('nomor_pemesanan')" placeholder="Nomor Perbandingan" class="w-full p-2.5 text-sm" readonly />
                                    <a href="{{ route('penerimaan-barang.cari-pemesanan') }}" id="cari-pemesanan" class="absolute top-0 end-0 p-2.5 h-full rounded-r-md inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </a>
                                </div>
                                @error('nomor_pemesanan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="py-1" id="tampil-data"></div>
                            <div class="py-1">
                                <a href="{{ route('penerimaan-barang.index') }}"
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
    <x-slot:js>
        <script type="module">
            'use strict'

            var penerimaanJs = function() {
                document.getElementById('cari-pemesanan')
                    .addEventListener('click', async function(e) {
                        e.preventDefault()

                        let response = await fetch(this.getAttribute("href"))
                        let content = await response.text()

                        const modal = document.getElementById('main-modal')
                        modal.innerHTML = content
                        modal.classList.remove('hidden')

                        attachEventCloseModal()
                        pilihPemesanan()
                    })

                let cekNomorPemesanan = `{{ old('nomor_pemesanan') }}`
                if (cekNomorPemesanan != '') {
                    const url = `{{ url('penerimaan-barang/pilih-pemesanan') }}/${cekNomorPemesanan}`
                    getDataPemesanan(url, cekNomorPemesanan)
                }

                function attachEventCloseModal() {
                    let buttons = document.querySelectorAll('[data-modal-hide]')

                    buttons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault()
                            document.getElementById(this.dataset.modalHide).classList.add('hidden')
                        })
                    });
                }

                function pilihPemesanan() {
                    let rows = document.querySelectorAll('[data-pemesanan]')
                    rows.forEach(row => {
                        row.addEventListener('click', function(e) {
                            e.preventDefault()

                            if (document.getElementById('nomor_pemesanan').value != this.dataset.pemesanan) {
                                getDataPemesanan(this.dataset.url, this.dataset.pemesanan)
                            }
                            document.getElementById('main-modal').classList.add('hidden')
                        })
                    })
                }

                async function getDataPemesanan(url, nomor) {
                    let response = await fetch(url)
                    let content = await response.text()

                    document.querySelector('[name="nomor_pemesanan"]').value = nomor
                    document.getElementById('tampil-data').innerHTML = content
                }
            }()
        </script>
    </x-slot:js>
</x-app-layout>
