<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Spesifikasi</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total</th>
            <th>Nomor Pengajuan</th>
            <th>Tanggal Pengajuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($riwayat_barang as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->spesifikasi }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->harga_satuan }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->nomor }}</td>
                <td>{{ $item->tanggal ? date('d-m-Y', strtotime($item->tanggal)) : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>