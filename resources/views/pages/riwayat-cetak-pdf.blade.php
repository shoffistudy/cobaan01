<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Riwayat Barang</title>
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
                <h1>RIWAYAT BARANG</h1>
                <p>No. : {{ $riwayat_barang->nomor }}</p>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <table class="table-borderless">
            <tr>
                <td class="row-title">Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($riwayat_barang->created_at)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="row-title">Jenis Proses</td>
                <td>: {{ $riwayat_barang->process_type }}</td>
            </tr>
            <tr>
                <td class="row-title">Nama Barang</td>
                <td>: {{ $riwayat_barang->pengajuanDetail->nama_barang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="row-title">Jumlah</td>
                <td>: {{ $riwayat_barang->quantity }}</td>
            </tr>
            <tr>
                <td class="row-title">Harga Satuan</td>
                <td>: {{ number_format($riwayat_barang->harga_satuan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="row-title">Spesifikasi</td>
                <td>: {{ $riwayat_barang->spesifikasi }}</td>
            </tr>
            <tr>
                <td class="row-title">Keterangan</td>
                <td>: {{ $riwayat_barang->status ?? '-' }}</td>
            </tr>
            <tr>
                <td class="row-title">User</td>
                <td>: {{ $riwayat_barang->user->name ?? '-' }}</td>
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
            <tr>
                <td align="center">1</td>
                <td>{{ $riwayat_barang->pengajuanDetail->nama_barang ?? '-' }}</td>
                <td>{{ $riwayat_barang->spesifikasi }}</td>
                <td align="center">{{ $riwayat_barang->quantity }}</td>
                <td align="right">{{ number_format($riwayat_barang->harga_satuan, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($riwayat_barang->quantity * $riwayat_barang->harga_satuan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th colspan="5" align="right">Total Harga</th>
                <th align="right">{{ number_format($riwayat_barang->quantity * $riwayat_barang->harga_satuan, 0, ',', '.') }}</th>
            </tr>
        </table>
    </div>

    <div style="text-align: right">
        <p style="padding: 0; margin-bottom: 0;">Madiun, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        <p style="padding: 0; margin: 0;">Dibuat Oleh,</p>
        <p>{{ $riwayat_barang->user->name ?? '-' }}</p>
    </div>
</body>

</html>
