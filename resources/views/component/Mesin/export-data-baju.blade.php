<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data LK Baju {{ $dataLk->BarangMasukDisainer->nama_tim }}</title>
    <style>
        table {
            border-collapse: collapse;
            margin-right: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>

    @if ($dataLk->Gambar->file_baju_player)
    <h4 style="text-transform: uppercase; margin-top: -40px">{{ $dataLk->kota_produksi }}</h4><br>
    <h3 style="text-transform: uppercase; text-align: center; margin-top: -60px">
        {{$dataLk->BarangMasukDisainer->nama_tim }} <br> {{ $dataLk->no_order }}</h3><br>
    <h4 style="text-transform: uppercase; margin-left: 541px; margin-top: -80px">
        @if ($dataLk->ket_hari == 'Express')
        <span style="color: red">DEADLINE Express <br> </span> <span style="color: red;margin-left: 40px;">{{
            $dataLk->deadline
            }}</span>
        @elseif ($dataLk->ket_hari == 'Normal')
        DEADLINE Normal <br> <span style="margin-left: 40px;">{{
            $dataLk->deadline
            }}</span>
        @endif
    </h4><br>
    <table style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -50px;">
        <tr>
            <style>
                .gambarplayer {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarplayer" src="{{ public_path('storage/'. $dataLk->Gambar->file_baju_player)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_lengan_player_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->LenganPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kera_baju_player_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_baju_player }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_baju_player }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_baju_player }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_baju_player }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_baju_pelayer !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_baju_pelatih)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarpelatih {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarpelatih" src="{{ public_path('storage/'. $dataLk->Gambar->file_baju_pelatih)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_lengan_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->LenganPelatih->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_baju_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraPelatih->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_baju_pelatih }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_baju_pelatih }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_baju_pelatih }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_baju_pelatih }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_baju_pelatih !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_baju_kiper)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarkiper {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarkiper" src="{{ public_path('storage/'. $dataLk->Gambar->file_baju_kiper)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_lengan_kiper_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->LenganKiper->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_baju_kiper_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraKiper->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_baju_kiper }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_baju_kiper }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_baju_kiper }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_baju_kiper }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_baju_kiper !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_baju_1)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarbaju1 {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarbaju1" src="{{ public_path('storage/'. $dataLk->Gambar->file_baju_1)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_lengan_1_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->Lengan1->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_baju_1_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->Kera1->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_baju_1 }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_baju_1 }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_baju_1 }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_baju_1 }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_baju_1 !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_celana_player)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarcelanaplayer {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarcelanaplayer" src="{{ public_path('storage/'. $dataLk->Gambar->file_celana_player)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_celana_player_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->CelanaPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_celana_player_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_celana_player }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_celana_player }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_celana_player }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_celana_player }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_celana_pelayer !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_celana_pelatih)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarcelanapelatih {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarcelanapelatih"
                    src="{{ public_path('storage/'. $dataLk->Gambar->file_celana_pelatih)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_celana_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->CelanaPelatih->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_celana_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_celana_pelatih }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_celana_pelatih }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_celana_pelatih }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_celana_pelatih }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_celana_pelatih !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_celana_kiper)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarcelanakiper {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarcelanakiper" src="{{ public_path('storage/'. $dataLk->Gambar->file_celana_kiper)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_celana_kiper_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->CelanaKiper->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_celana_kiper_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_celana_kiper }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_celana_kiper }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_celana_kiper }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_celana_kiper }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_celana_kiper !!}
        </p>
    </div>
    @endif

    @if ($dataLk->Gambar->file_celana_1)
    <table
        style="width: 110%; margin-left: -35px; text-transform: uppercase; margin-top: -30px;  page-break-before: always;">
        <tr>
            <style>
                .gambarcealana1 {
                    margin-top: 20px;
                    margin-bottom: 20px;
                    max-width: 530px;
                    min-width: 530px;
                    margin-left: 120px;
                }
            </style>
            <td colspan="2">
                <img class="gambarcealana1" src="{{ public_path('storage/'. $dataLk->Gambar->file_celana_1)}}">
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($dataLk->pola_celana_1_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->Celana1->gambar) }}" alt="">
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->kerah_celana_1_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $dataLk->KeraPlayer->gambar) }}" alt="">
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{ $dataLk->ket_tambahan_celana_1 }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{ $dataLk->total_celana_1 }} PCS </td>
        </tr>
    </table>
    <style>
        .container {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .container p {
            font-weight: bold
        }

        .container1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            text-transform: uppercase;
            margin-top: 10px;
        }
    </style>
    <div class="container">
        <p>Admin : {{ $dataLk->UsersOrder->name }}</p> <br>
        <p style="margin-top: -56px; margin-left: 400px">Disainer : {{ $dataLk->Users->name }}</p> <br>
        <p style="margin-top: -40px;">Mesin Print : {{ $dataLk->jenis_mesin }}</p><br>
        <p style="margin-left: 400px; margin-top: -60px;">Layout : {{ $dataLk->UsersLk->name }}</p> <br>
        <p style="margin-top: -45px;">Jenis Sablon : {{ $dataLk->jenis_sablon_celana_1 }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{ $dataLk->jenis_kain_celana_1 }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->keterangan_celana_1 !!}
        </p>
    </div>
    @endif

    <style>
        .containerKeteranganLengkap {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            height: 100%;
            text-transform: uppercase;
        }
    </style>
    <div class="containerKeteranganLengkap">
        <p style="font-weight: bold">
            {!! $dataLk->keterangan_lengkap !!}
        </p>
    </div>
    <style>
        .containerKeteranganLengkap1 {
            border: 1px solid black;
            padding: 5px;
            width: 760px;
            margin-left: -35px;
            height: 100%;
            text-transform: uppercase;

            /* page-break-before: always; */
        }
    </style>
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $layout->file_tangkap_layar) }}" alt="">
    </div>
</body>

</html>
