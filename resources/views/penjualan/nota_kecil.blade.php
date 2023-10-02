<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Penjualan</title>
    <style type="text/css">
        * {
            font-family: Arial, sans-serif;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        p {
            font-size: 10px;
        }

        .top-min {
            margin-top: -10px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .bold {
            font-weight: bold;
        }

        .d-block {
            display: block;
        }

        hr {
            border: 0;
            border-top: 1px solid #000;
        }

        .hr-dash {
            border-style: dashed none none none;
        }

        table {
            font-size: 10px;
        }

        table thead tr td {
            padding: 5px;
        }

        .w-100 {
            width: 100%;
        }

        .line {
            border: 0;
            border-top: 1px solid #000;
            border-style: dashed none none none;
        }

        .body {
            margin-top: -10px;
        }

        .b-p {
            font-size: 12px !important;
        }

        .w-long {
            width: 80px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="uppercase bold d-block center b-p"><img src="{{ asset('/images/spos.png') }}" alt="Logo"
                srcset="" style="width: 110px; height:auto;" /></p>
        <p class="top-min d-block center">{{ $setting->alamat }}</p>
        <p class="top-min d-block center">{{ $setting->telepon }}</p>
        <hr class="hr-dash">
        <table class="w-100">
            <tr>
                <td class="left w-long">No Transaksi : </td>
                <td class="left">{{ tambah_nol_didepan($penjualan->id_penjualan, 7) }}</td>
                <td class="right">Kasir : </td>
                <td class="right">{{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="left" colspan="3">{{ date('d M, Y') }}</td>
            </tr>
        </table>
        <hr class="hr-dash">
    </div>

    <div class="body">
        <table class="w-100">
            <thead>
                <tr>
                    <td width="5%">No</td>
                    <td width="30%">Nama Barang</td>
                    <td>Qty</td>
                    <td>Harga</td>
                    <td>Diskon</td>
                    <td>Jumlah</td>
                </tr>
                <tr>
                    <td colspan="8" class="line"></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $key => $s)
                    <tr>
                        <td width="5%">{{ (int) $key + 1 }}</td>
                        <td width="35%">{{ $s->produk->nama_produk }}</td>
                        <td>{{ $s->jumlah }}</td>
                        <td>{{ number_format($s->harga_jual, 2, ',', '.') }}</td>
                        <td>{{ $s->produk->diskon . '%' }}</td>
                        <td>{{ number_format($s->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr class="hr-dash">
        <table class="w-100">
            <tr>
                <td class="left">Harga Jual (Jumlah : {{ $penjualan->total_item }})</td>
                <td class="right">{{ number_format($penjualan->total_harga, 2, ',', '.') }}</td>
            </tr>
            {{-- <tr>
                <td class="left">Diskon ({{ $penjualan->diskon }}%)</td>
                <td class="right">
                    {{ number_format(($penjualan->total_harga * $penjualan->diskon) / 100, 2, ',', '.') }}
                </td>
            </tr> --}}

        </table>
        <hr class="hr-dash">
        <table class="w-100">
            <tr>
                <td class="left">Total</td>
                <td class="right">{{ number_format($penjualan->bayar, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="left">Tunai</td>
                <td class="right">{{ number_format($penjualan->diterima, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="left">Kembali</td>
                <td class="right">{{ number_format($penjualan->diterima - $penjualan->bayar, 2, ',', '.') }}</td>
            </tr>
            {{-- <tr>
                <td class="left">Anda Hemat</td>
                <td class="right">
                    {{ number_format($detail->diskon, 2, ',', '.') }}</td>
            </tr> --}}
        </table>
        <hr class="hr-dash">
    </div>
    <div class="footer">
        <p class="center">Terima Kasih Telah Berkunjung</p>
    </div>
    </div>


</body>

</html>
