<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pengajuan Pembelian Barang
        </h2>
    </x-slot>

    <div class="py-4"> 
        <div class="max-w-full mx-auto px-4"> 
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col gap-2">
                    @can('create ' . request()->path())
                        <div>
                            <a href="{{ route('pengajuan-pembelian-barang.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
                                        Nama Pengajuan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Keterangan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Barang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        User Input
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
                                @foreach ($list_pengajuan as $pengajuan)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $pengajuan->nomor }}
                                        </th>
                                        <td class="px-6 py-4">{{ $pengajuan->nama_pengajuan }}</td>
                                        <td class="px-6 py-4">{{ $pengajuan->keterangan }}</td>
                                        <td class="px-6 py-4">{{ $pengajuan->detail_count }}</td>
                                        <td class="px-6 py-4">{{ $pengajuan->user->name }}</td>
                                        <td class="px-6 py-4">
                                            @if ($pengajuan->batal)
                                                <span class="text-red-600">Dibatalkan</span>
                                                <p class="mb-0 text-gray-600">{{ $pengajuan->keterangan_batal }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('pengajuan-pembelian-barang.show', $pengajuan->id) }}" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline">Detail</a>

                                            @if (!$pengajuan->batal && auth()->user()->can('update ' . request()->path()) && $pengajuan->perbandingan)
                                                <a href="{{ route('pengajuan-pembelian-barang.edit', $pengajuan->id) }}" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline">Edit</a>
                                                <a href="{{ route('pengajuan-pembelian-barang.batal', $pengajuan->id) }}" data-form="form-{{ $pengajuan->id }}" class="font-medium text-blue-600 me-1 dark:text-blue-500 hover:underline batal">Batal</a>
                                                <form action="{{ route('pengajuan-pembelian-barang.batal', $pengajuan->id) }}" id="form-{{ $pengajuan->id }}" class="hidden" method="post">
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
                        {!! $list_pengajuan->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot:js>
        <script>
            'use strict'

            var pengajuanJs = function() {
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
