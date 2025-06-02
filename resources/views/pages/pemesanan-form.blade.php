<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Pemesanan</h2>
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
                        <form class="max-w-full mx-auto" method="POST" action="{{ route('pemesanan-barang.store') }}">
                            @csrf
                            <div class="py-1">
                                <x-input-label for="nomor_perbandingan" value="Nomor Perbandingan" />
                                <div class="relative w-full">
                                    <x-text-input name="nomor_perbandingan" id="nomor_perbandingan" :value="old('nomor_perbandingan')" placeholder="Nomor Perbandingan" class="w-full p-2.5 text-sm" readonly />
                                    <a href="{{ route('pemesanan-barang.cari-perbandingan') }}" id="cari-perbandingan" class="absolute top-0 end-0 p-2.5 h-full rounded-r-md inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </a>
                                </div>
                                @error('nomor_perbandingan')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="py-1" id="tampil-data"></div>
                            <div class="py-1">
                                <a href="{{ route('pemesanan-barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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

            var pemesananJs = function() {
                document.getElementById('cari-perbandingan')
                    .addEventListener('click', async function(e) {
                        e.preventDefault()

                        let response = await fetch(this.getAttribute("href"))
                        let content = await response.text()

                        const modal = document.getElementById('main-modal')
                        modal.innerHTML = content
                        modal.classList.remove('hidden')

                        attachEventCloseModal()
                        pilihPerbandingan()
                    })

                let cekNomorPerbandingan = `{{ old('nomor_perbandingan') }}`
                const searchParams = (new URL(window.location.href)).searchParams
                if (cekNomorPerbandingan == '' && searchParams.get('ref') == 'notification' && searchParams.get('nomor')) {
                    cekNomorPerbandingan = searchParams.get('nomor')
                }
                
                if (cekNomorPerbandingan != '') {
                    const url = `{{ url('pemesanan-barang/pilih-perbandingan') }}/${cekNomorPerbandingan}`
                    getDataPerbandingan(url, cekNomorPerbandingan)
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

                function pilihPerbandingan() {
                    let rows = document.querySelectorAll('[data-perbandingan]')
                    rows.forEach(row => {
                        row.addEventListener('click', function(e) {
                            e.preventDefault()

                            if (document.getElementById('nomor_perbandingan').value != this.dataset.perbandingan) {
                                getDataPerbandingan(this.dataset.url, this.dataset.perbandingan)
                            }
                            document.getElementById('main-modal').classList.add('hidden')
                        })
                    })
                }

                async function getDataPerbandingan(url, nomor) {
                    let response = await fetch(url)
                    let content = await response.text()

                    document.querySelector('[name="nomor_perbandingan"]').value = nomor
                    document.getElementById('tampil-data').innerHTML = content
                }
            }()
        </script>
    </x-slot:js>
</x-app-layout>
