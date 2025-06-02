<div class="flex flex-col gap-2">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="text-sm text-left rtl:text-right">
            <tr>
                <th class="py-3 px-4">Nomor</th>
                <td>: {{ $pemesanan->nomor }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">Vendor</th>
                <td>: {{ $pemesanan->vendor->nama }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">PIC</th>
                <td>: {{ $pemesanan->pic }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">Kontak PIC</th>
                <td>: {{ $pemesanan->kontak_pic }}</td>
            </tr>
            <tr>
                <th class="py-3 px-4">Tanggal Input</th>
                <td>: {{ $pemesanan->tanggal }}</td>
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
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan->detail as $barang)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $barang->spesifikasi }}</td>
                            <td class="px-6 py-4">{{ $barang->jumlah }}</td>
                            <td class="px-6 py-4">
                                <div>
                                    <x-text-input name="keterangan[{{ $barang->id }}]" id="keterangan-{{ $barang->id }}" :value="old('keterangan.' . $barang->id)" placeholder="Keterangan" class="w-full p-2.5 text-sm" />
                                    @error('keterangan.' . $barang->id)
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
