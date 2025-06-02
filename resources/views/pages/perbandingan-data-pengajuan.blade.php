<div class="flex flex-col gap-2">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="text-sm text-left rtl:text-right">
            <tr>
                <th class="py-3 px-4">Nomor</th>
                <td>: {{ $pengajuan->nomor }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">Nama Pengajuan</th>
                <td>: {{ $pengajuan->nama_pengajuan }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">User Input</th>
                <td>: {{ $pengajuan->user->name }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">Tanggal Input</th>
                <td>: {{ $pengajuan->tanggal }}</td>
            </tr>
        </table>
        <div class="px-4">
            <h4 class="font-bold text-lg mb-2">List Barang</h4>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Barang
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Spesifikasi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga Satuan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuan->detail as $barang)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $barang->spesifikasi }}</td>
                            <td class="px-6 py-4">{{ $barang->jumlah }}</td>
                            <td class="px-6 py-4">{{ number_format($barang->harga_satuan) }}</td>
                            <td class="px-6 py-4">{{ number_format($barang->jumlah * $barang->harga_satuan) }}</td>
                        </tr>
                    @endforeach
                    <tr class="text-gray-700">
                        <th colspan="4" class="text-end font-bold px-6 py-4">Grang Total</th>
                        <th class="px-6 py-4">{{ number_format($pengajuan->detail->sum(fn($barang) => $barang->jumlah * $barang->harga_satuan)) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
