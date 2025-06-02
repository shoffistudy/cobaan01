<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="text-sm text-left rtl:text-right">
        <tr>
            <th class="py-3 px-4">Nomor</th>
            <td>: {{ $perbandingan->nomor }}</td>
        </tr>
        <tr>
            <th class="py-3 px-4">Judul</th>
            <td>: {{ $perbandingan->judul }}</td>
        </tr>
        <tr>
            <th class="py-3 px-4">User Input</th>
            <td>: {{ $perbandingan->user->name }}</td>
        </tr>
        <tr>
            <th class="py-3 px-4">Tanggal Input</th>
            <td>: {{ $perbandingan->tanggal }}</td>
        </tr>
    </table>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nama Barang
                </th>
                <th scope="col" class="px-6 py-3">
                    Qty
                </th>
                <th scope="col" class="px-6 py-3">
                    Estimasi Harga
                </th>
                @foreach ($list_vendor as $nama_vendor => $list_barang)
                    <th scope="col" class="px-6 py-3">
                        {{ $nama_vendor }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($perbandingan->pengajuanDetail as $barang)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $barang->nama_barang }}
                    </th>
                    <td class="px-6 py-4 text-gray-900">{{ $barang->jumlah }}</td>
                    <td class="px-6 py-4">
                        <p class="text-gray-900">{{ number_format($barang->jumlah * $barang->harga_satuan) }}</p>
                        <span class="text-gray-400 text-xs">{{ '@' . number_format($barang->harga_satuan) }}</span>
                    </td>
                    @foreach ($list_vendor as $nama_vendor => $list_barang)
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <input type="radio" id="barang-{{ $barang->id }}-{{ str_replace(' ', '', strtolower($nama_vendor)) }}" name="barang[{{ $barang->id }}]" @checked(old('barang.' . $barang->id) == $list_barang[$barang->id]['perbandingan_vendor_id']) value="{{ $list_barang[$barang->id]['perbandingan_vendor_id'] }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="barang-{{ $barang->id }}-{{ str_replace(' ', '', strtolower($nama_vendor)) }}">
                                    <p class="text-gray-900">{{ number_format($list_barang[$barang->id]['total_harga']) }}</p>
                                    <span class="text-gray-400 text-xs">{{ '@' . number_format($list_barang[$barang->id]['harga_satuan']) }}</span>
                                </label>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot class="text-gray-700 bg-gray-300">
            <th scope="col" class="px-6 py-3" colspan="3">
                Ketentuan Pembayaran
            </th>
            @foreach ($perbandingan->perbandinganHargaVendor as $perbandingan_harga_vendor)
                <th scope="col" class="px-6 py-3">
                    {{ $perbandingan_harga_vendor->ketentuan_pembayaran }}
                </th>
            @endforeach
        </tfoot>
    </table>
</div>
