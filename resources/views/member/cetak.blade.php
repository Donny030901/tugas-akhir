<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kartu Member</title>

    <style>
        .box {
            position: relative;
        }

        .card {
            width: 85.60mm;
        }

        .logo {
            position: absolute;
            top: -15pt;
            right: 80pt;
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #fff !important;
        }

        .logo p {
            text-align: right;
            margin-right: 1pt;
        }

        .logo img {
            position: absolute;
            top: 25pt;
            width: 25px;
            height: 25px;
            right: 2pt;
        }

        .nama {
            position: absolute;
            top: 35pt;
            right: 80pt;
            font-size: 8px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: #fff !important;
        }

        .telepon {
            position: absolute;
            top: 45pt;
            font-size: 8px;
            right: 80pt;
            color: #fff;
        }

        .barcode {
            position: absolute;
            top: 35pt;
            left: 64pt;
            border: 1px solid #fff;
            padding: .5px;
            background: #fff;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <section style="border: 1px solid #fff">
        <table width="100%">
            @foreach ($datamember as $key => $data)
                <tr>
                    @foreach ($data as $m)
                        <td class="text-center">
                            <div class="box">
                                <img src="{{ asset($setting->path_kartu_member) }}" alt="card" width="50%">
                                <div class="logo">
                                    <p>{{ $setting->nama_perusahaan }}</p>
                                    <img src="{{ asset($setting->path_logo) }}" alt="logo">
                                </div>
                                <div class="nama">{{ $m->nama }}</div>
                                <div class="telepon">{{ $m->telepon }}</div>
                                <div class="barcode text-left">
                                    <img src="data:image/png;base64, {{ DNS2D::getBarcodePNG("$m->kode_member", 'QRCODE') }}"
                                        alt="qrcode" height="25" width="25">
                                </div>
                            </div>
                        </td>
                        @if (count($datamember) == 1)
                            <td class="text-center" style="width: 50%;"></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </section>

</body>

</html>
