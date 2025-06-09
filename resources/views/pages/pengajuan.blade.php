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

                    {{-- Tombol Tambah --}}
                    @can('create pengajuan-pembelian-barang')
                        <div>
                            <a href="{{ route('pengajuan-pembelian-barang.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Tambah
                            </a>
                        </div>
                    @endcan

                    {{-- Alert --}}
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <span class="font-medium">Sukses!</span> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">Error!</span> {{ session('error') }}
                        </div>
                    @endif


                    {{-- Table --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Nomor</th>
                                    <th class="px-6 py-3">Nama Pengajuan</th>
                                    <th class="px-6 py-3">Keterangan</th>
                                    <th class="px-6 py-3">Jumlah Barang</th>
                                    <th class="px-6 py-3">User Input</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_pengajuan as $pengajuan)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $pengajuan->nomor }}
                                        </td>
                                        <td class="px-6 py-4">{{ $pengajuan->nama_pengajuan }}</td>
                                        <td class="px-6 py-4">{{ $pengajuan->keterangan }}</td>
                                        <td class="px-6 py-4">{{ $pengajuan->detail_count }}</td>
                                        <td class="px-6 py-4">{{ $pengajuan->user->name }}</td>
                                        <td class="px-6 py-4">
                                            @if ($pengajuan->batal)
                                                <span class="text-red-600 font-semibold">Dibatalkan</span>
                                                <p class="text-xs text-gray-500">{{ $pengajuan->keterangan_batal }}</p>

                                            @elseif ($pengajuan->perbandingan)
                                                <span class="text-yellow-600 font-semibold">Proses Perbandingan</span>

                                            @else
                                                <span class="text-blue-600 font-semibold">Menunggu</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 space-x-1">
                                            {{-- Tombol Detail selalu ada --}}
                                            <a href="{{ route('pengajuan-pembelian-barang.show', $pengajuan->id) }}"
                                                class="text-blue-600 hover:underline">Detail</a>

                                            {{-- Tombol Edit: hanya muncul jika belum dibatalkan dan user punya akses --}}
                                            @can('update pengajuan-pembelian-barang')
                                                @if (!$pengajuan->batal)
                                                    <a href="{{ route('pengajuan-pembelian-barang.edit', $pengajuan->id) }}"
                                                        class="text-blue-600 hover:underline">Edit</a>
                                                @endif
                                            @endcan

                                            {{-- Tombol Batal --}}
                                            @can('delete pengajuan-pembelian-barang')
                                                @if (!$pengajuan->batal)
                                                    <a href="{{ route('pengajuan-pembelian-barang.batal', $pengajuan->id) }}"
                                                        data-form="form-{{ $pengajuan->id }}"
                                                        class="text-blue-600 hover:underline batal">Batal</a>

                                                    {{-- Hidden form --}}
                                                    <form action="{{ route('pengajuan-pembelian-barang.batal', $pengajuan->id) }}"
                                                        id="form-{{ $pengajuan->id }}" class="hidden" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="keterangan">
                                                    </form>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div>{!! $list_pengajuan->links() !!}</div>

                </div>
            </div>
        </div>
    </div>

    {{-- JS Section --}}
    <x-slot:js>
        <script>
            document.querySelectorAll('.batal').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const keterangan = prompt("Ketikkan alasan pembatalan:");
                    if (keterangan) {
                        const form = document.getElementById(this.dataset.form);
                        const input = form.querySelector('input[name="keterangan"]');
                        input.value = keterangan;
                        form.submit();
                    }
                });
            });
        </script>
    </x-slot:js>
</x-app-layout>
