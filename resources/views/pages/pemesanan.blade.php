<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pemesanan Barang
        </h2>
    </x-slot>

    <div class="py-4"> 
        <div class="max-w-full mx-auto px-4"> 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    {{-- @can('create ' . request()->path()) --}}
                    @can('create pemesanan-barang')
                        <div>
                            <a href="{{ route('pemesanan-barang.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Tambah
                            </a>
                        </div>
                    @endcan
                    @session('success')
                        <div>
                            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <span class="font-medium">Sukses!</span> {{ session('success') }}.
                            </div>
                        </div>
                    @endsession
                    @session('error')
                        <div class="px-4">
                            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">Error!</span> {{ session('error') }}.
                            </div>
                        </div>
                    @endsession
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nomor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nomor Perbandingan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Vendor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        PIC
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Barang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        User Input
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_pemesanan as $pemesanan)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $pemesanan->nomor }}
                                        </th>
                                        <td class="px-6 py-4">{{ $pemesanan->perbandingan->nomor }}</td>
                                        <td class="px-6 py-4">{{ $pemesanan->vendor->nama }}</td>
                                        <td class="px-6 py-4">{{ $pemesanan->pic }}</td>
                                        <td class="px-6 py-4">{{ $pemesanan->detail_count }}</td>
                                        <td class="px-6 py-4">{{ $pemesanan->user->name }}</td>
                                        <td class="px-6 py-4">{{ $pemesanan->tanggal }}</td>
                                        <td class="px-6 py-4">
                                            @if ($pemesanan->batal)
                                                <span class="text-red-600">Dibatalkan</span>
                                                <p class="mb-0 text-gray-600">{{ $pemesanan->keterangan_batal }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <!-- untuk tombol aksi -->
                                            <a href="{{ route('pemesanan-barang.show', $pemesanan->id) }}" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline">Detail</a>
                                            <a href="{{ route('pemesanan-barang.cetak', $pemesanan->id) }}" target="_blank" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline">Cetak</a>

                                            @if (!$pemesanan->batal && auth()->user()->can('update ' . request()->path()))
                                                <a href="{{ route('pemesanan-barang.batal', $pemesanan->id) }}" data-form="form-{{ $pemesanan->id }}" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline batal">Batal</a>
                                                <form action="{{ route('pemesanan-barang.batal', $pemesanan->id) }}" id="form-{{ $pemesanan->id }}" class="hidden" method="post">
                                                    @csrf
                                                    <input type="hidden" name="keterangan">
                                                    @method('put')
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {!! $list_pemesanan->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- penambahan script tombol batal diklik, akan diminta untuk mengisi keterangan batal dan saat diklik ok data akan dibatalkan. --}}
    <x-slot:js>
        <script>
            'use strict'

            var pemesananJs = function() {
                const buttons = document.querySelectorAll('.batal')

                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault()
                        const url = this.getAttribute("href")

                        let keterangan = prompt("Ketikan alasan batal")
                        if (keterangan) {
                            const formId = this.dataset.form
                            const form = document.getElementById(formId)
                            const children = form.children

                            for (const [key, element] of Object.entries(children)) {
                                if (element.getAttribute('name') == 'keterangan') {
                                    element.value = keterangan
                                }
                            }

                            form.submit()
                        }
                    })
                });
            }()
        </script>
    </x-slot:js>
</x-app-layout>


