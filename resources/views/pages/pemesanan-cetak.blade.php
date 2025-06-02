<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Pemesanan Barang {{ $pemesanan->nomor }}</title>
    <style>
        .title {
            text-align: center;
            margin-bottom: 30px;
        }

        .title-flex {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .title-text {
            text-align: center;
        }

        .title-text h1 {
            font-size: 14pt;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .title-text p {
            margin-top: -3px;
            font-weight: bold;
            margin-bottom: 0;
        }

        table {
            border-collapse: collapse;
        }

        table.table-borderless {
            border: none;
        }

        td.row-title {
            padding-left: 0;
            padding-right: 1rem;
            padding-top: .25rem;
            padding-bottom: .25rem;
        }

        table.table-bordered tr>th {
            background-color: gainsboro;
            font-weight: bold;
        }

        table.table-bordered tr>th,
        table.table-bordered tr>td {
            border: 1px solid #000;
            border-collapse: collapse;
            border-style: solid;
            padding: .2rem .5rem;
        }
    </style>
</head>

<body>
    <div class="title">
        <div class="title-flex">
            <img src="{{ public_path('img/logoims.png') }}" alt="Logo" class="logo">
            <div class="title-text">
                <h1>PEMESANAN BARANG</h1>
                <p>No. : {{ $pemesanan->nomor }}</p>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <table class="table-borderless">
            <tr>
                <td class="row-title">Tanggal</td>
                <td>: {{ $pemesanan->tanggal }}</td>
            </tr>
            <tr>
                <td class="row-title">Rekanan</td>
                <td>: {{ $pemesanan->vendor->nama }}</td>
            </tr>
            <tr>
                <td class="row-title">NPWP</td>
                <td>: {{ $pemesanan->vendor->npwp }}</td>
            </tr>
            <tr>
                <td class="row-title">PIC</td>
                <td>: {{ $pemesanan->pic }}</td>
            </tr>
            <tr>
                <td class="row-title">Kontak PIC</td>
                <td>: {{ $pemesanan->kontak_pic }}</td>
            </tr>
        </table>
    </div>

    <div>
        <table class="table-bordered">
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Spesifikasi</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
            @foreach ($pemesanan->detail as $barang)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->spesifikasi }}</td>
                    <td align="center">{{ $barang->jumlah }}</td>
                    <td align="right">{{ number_format($barang->harga_satuan, 0, 2) }}</td>
                    <td align="right">{{ number_format($barang->jumlah * $barang->harga_satuan, 0, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="5" align="right">Grand Total</th>
                <th align="right">{{ number_format($pemesanan->detail->sum(fn($barang) => $barang->jumlah * $barang->harga_satuan), 0, 2) }}</th>
            </tr>
        </table>
    </div>

    <div style="text-align: right">
        <p style="padding: 0; margin-bottom: 0;">Madiun, {{ date_format(date_create($pemesanan->tanggal), 'd F Y') }}</p>
        <p style="padding: 0; margin: 0;">Dibuat Oleh,</p>
        <p>{{ $pemesanan->user->name }}</p>
    </div>
</body>

</html>
