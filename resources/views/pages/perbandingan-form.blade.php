<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $perbandingan->id ? 'Edit' : 'Tambah' }} Perbandingan</h2>
    </x-slot>

    <div class="py-4"> 
        <div class="max-w-full mx-auto px-4"> 
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
                        <form class="max-w-full mx-auto" method="POST" action="{{ $perbandingan->id ? route('perbandingan-harga.update', $perbandingan->id) : route('perbandingan-harga.store') }}">
                            @csrf
                            @if ($perbandingan->id)
                                @method('put')
                            @endif
                            <div class="py-1">
                                <x-input-label for="judul" value="Judul" />
                                <x-text-input name="judul" placeholder="Judul Perbandingan" id="judul" :value="$errors->has('judul') ? old('judul') : $perbandingan->judul" class="w-full p-2.5 text-sm" />
                                @error('judul')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="py-1">
                                <x-input-label for="nomor_pengajuan" value="Nomor Pengajuan" />
                                <div class="relative w-full">
                                    <x-text-input name="nomor_pengajuan" id="nomor_pengajuan" :value="$errors->has('nomor_pengajuan') ? old('nomor_pengajuan') : $perbandingan->pengajuan?->nomor" placeholder="Nomor Pengajuan" class="w-full p-2.5 text-sm" readonly />
                                    <a href="{{ route('perbandingan-harga.cari-pengajuan') . ($perbandingan->id ? "?id=$perbandingan->id" : null) }}" id="cari-pengajuan" class="absolute top-0 end-0 p-2.5 h-full rounded-r-md inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </a>
                                </div>
                                @error('nomor_pengajuan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="py-1" id="tampil-data">
                                @if ($perbandingan->id)
                                    @include('pages.perbandingan-data-pengajuan', ['pengajuan' => $perbandingan->pengajuan])
                                @endif
                            </div>
                            <div class="py-1">
                                <a href="{{ route('perbandingan-harga.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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

            var perbandinganJs = function() {
                document.getElementById('cari-pengajuan')
                    .addEventListener('click', async function(e) {
                        e.preventDefault()

                        let response = await fetch(this.getAttribute("href"))
                        let content = await response.text()

                        const modal = document.getElementById('main-modal')
                        modal.innerHTML = content
                        modal.classList.remove('hidden')
                        attachEventCloseModal()
                        pilihPengajuan()
                    })

                let cekNomorPengajuan = `{{ old('nomor_pengajuan') }}`
                if (cekNomorPengajuan != '') {
                    const url = `{{ url('perbandingan-harga/pilih-pengajuan') }}/${cekNomorPengajuan}`
                    getDataPengajuan(url, cekNomorPengajuan)
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

                function pilihPengajuan() {
                    let rows = document.querySelectorAll('[data-pengajuan]')
                    rows.forEach(row => {
                        row.addEventListener('click', function(e) {
                            e.preventDefault()

                            if (document.getElementById('nomor_pengajuan').value != this.dataset.pengajuan) {
                                getDataPengajuan(this.dataset.url, this.dataset.pengajuan)
                            }
                            document.getElementById('main-modal').classList.add('hidden')
                        })
                    })
                }

                async function getDataPengajuan(url, nomor) {
                    let response = await fetch(url)
                    let content = await response.text()

                    document.querySelector('[name="nomor_pengajuan"]').value = nomor
                    document.getElementById('tampil-data').innerHTML = content
                }
            }()
        </script>
    </x-slot:js>
</x-app-layout>
