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
                @if ($dataLk->BarangMasukCostumerServicesLkPlyer->first()->pola_lengan_player_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkPlyer as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->LenganPlayer->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkPlyer->first()->kera_baju_player_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkPlyer as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraPlayer->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>

            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkPlyer->first()->ket_tambahan_baju_player }}
            </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkPlyer->first()->total_baju_player }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkPlyer->first()->jenis_sablon_baju_player }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkPlyer->first()->jenis_kain_baju_player }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkPlyer->first()->keterangan_baju_pelayer !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLkPelatih->first()->pola_lengan_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkPelatih as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->LenganPelatih->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkPelatih->first()->kerah_baju_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkPelatih as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraPelatih->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkPelatih->first()->ket_tambahan_baju_pelatih }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkPelatih->first()->total_baju_pelatih }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkPelatih->first()->jenis_sablon_baju_pelatih }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkPelatih->first()->jenis_kain_baju_pelatih }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkPelatih->first()->keterangan_baju_pelatih !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLkKiper->first()->pola_lengan_kiper_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkKiper as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->LenganKiper->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkKiper->first()->kerah_baju_kiper_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkKiper as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraKiper->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkKiper->first()->ket_tambahan_baju_kiper }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkKiper->first()->total_baju_kiper }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkKiper->first()->jenis_sablon_baju_kiper }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkKiper->first()->jenis_kain_baju_kiper }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkKiper->first()->keterangan_baju_kiper !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLk1->first()->pola_lengan_1_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLk1 as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->Lengan1->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLk1->first()->kerah_baju_1_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLk1 as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->Kera1->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLk1->first()->ket_tambahan_baju_1 }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLk1->first()->total_baju_1 }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLk1->first()->jenis_sablon_baju_1 }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLk1->first()->jenis_kain_baju_1 }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLk1->first()->keterangan_baju_1 !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->pola_celana_player_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelanaPlyer as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->CelanaCelanaPlayer->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->kerah_celana_player_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelanaPlyer as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraCelanaPlayer->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->ket_tambahan_celana_player }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->total_celana_player }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->jenis_sablon_celana_player }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->jenis_kain_celana_player }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkCelanaPlyer->first()->keterangan_celana_pelayer !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->pola_celana_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelanaPelatih as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->CelanaCelanapelatih->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->kerah_celana_pelatih_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelanaPelatih as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraCelanapelatih->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->ket_tambahan_celana_pelatih }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->total_celana_pelatih }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->jenis_sablon_celana_pelatih }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->jenis_kain_celana_pelatih }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkCelanaPelatih->first()->keterangan_celana_pelatih !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->pola_celana_kiper_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelanaKiper as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->CelanaCealanaKiper->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->kerah_celana_kiper_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelanaKiper as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraCealanaKiper->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->ket_tambahan_celana_kiper }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->total_celana_kiper }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->jenis_sablon_celana_kiper }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->jenis_kain_celana_kiper }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkCelanaKiper->first()->keterangan_celana_kiper !!}
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
                @if ($dataLk->BarangMasukCostumerServicesLkCelana1->first()->pola_celana_1_id == 1)
                <p style="font-weight: bold">Keterangan produksi ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Produksi</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="details">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelana1 as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->CelanaCelana1->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
            <td style="text-align: center">
                @if ($dataLk->BarangMasukCostumerServicesLkCelana1->first()->kerah_celana_1_id == 1)
                <p style="font-weight: bold">Keterangan model ada <br>dibagian tabel keterangan!!</p>
                @else
                <p style="margin-top: -5px; font-weight: bold">Model</p>
                <div style="border: 1px solid black; border-radius: 50%; width: 120px; height: 120px; display: inline-block; overflow: hidden;"
                    class="">
                    @foreach ($dataLk->BarangMasukCostumerServicesLkCelana1 as $item)
                    <img style="width: 100px; margin-top: 15px;"
                        src="{{ public_path('storage/'. $item->KeraCealana1->gambar) }}" alt="">
                    @endforeach
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold">{{
                $dataLk->BarangMasukCostumerServicesLkCelana1->first()->ket_tambahan_celana_1 }} </td>
            <td style="text-align: center; font-weight: bold">TOTAL {{
                $dataLk->BarangMasukCostumerServicesLkCelana1->first()->total_celana_1 }} PCS </td>
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
        <p style="margin-top: -45px;">Jenis Sablon : {{
            $dataLk->BarangMasukCostumerServicesLkCelana1->first()->jenis_sablon_celana_1 }}</p> <br>
        <p style="margin-left: 400px; margin-top: -65px;">Jenis Bahan : {{
            $dataLk->BarangMasukCostumerServicesLkCelana1->first()->jenis_kain_celana_1 }}</p>
    </div>
    <div class="container1">
        <p style="font-weight: bold">Keterangan : <br>
            {!! $dataLk->BarangMasukCostumerServicesLkCelana1->first()->keterangan_celana_1 !!}
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
    @foreach ($layout as $item)
    @foreach ($item->GamarTangkaplayar as $gambar)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_player) }}" alt="" loading="lazy">
    </div>
    @if ($gambar->file_tangkap_layar_pelatih)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_pelatih) }}" alt="" loading="lazy">
    </div>
    @endif

    @if ($gambar->file_tangkap_layar_kiper)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_kiper) }}" alt="" loading="lazy">
    </div>
    @endif

    @if ($gambar->file_tangkap_layar_1)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_1) }}" alt="" loading="lazy">
    </div>
    @endif

    @if ( $gambar->file_tangkap_layar_celana_pelayer)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_celana_pelayer) }}" alt="" loading="lazy">
    </div>
    @endif

    @if ($gambar->file_tangkap_layar_celana_pelatih)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_celana_pelatih) }}" alt="" loading="lazy">
    </div>
    @endif

    @if ($gambar->file_tangkap_layar_celana_kiper)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_celana_kiper) }}" alt="" loading="lazy">
    </div>
    @endif

    @if ($gambar->file_tangkap_layar_celana_1)
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $gambar->file_tangkap_layar_celana_1) }}" alt="" loading="lazy">
    </div>
    @endif

    @endforeach
    @endforeach

    {{-- @if(isset($formattedData['player']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['player']['file_tangkap_layar_player']) }}" alt=""
            loading="lazy">
    </div>
    @endif
    @if(isset($formattedData['pelatih']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['pelatih']['file_tangkap_layar_pelatih']) }}" alt="">
    </div>
    @endif
    @if(isset($formattedData['kiper']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['kiper']['file_tangkap_layar_kiper']) }}" alt="">
    </div>
    @endif
    @if(isset($formattedData['lk_1']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['lk_1']['file_tangkap_layar_1']) }}" alt="">
    </div>
    @endif
    @if(isset($formattedData['celana_player']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['celana_player']['file_tangkap_layar_celana_pelayer']) }}"
            alt="">
    </div>
    @endif
    @if(isset($formattedData['celana_pelatih']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['celana_pelatih']['file_tangkap_layar_celana_pelatih']) }}"
            alt="">
    </div>
    @endif
    @if(isset($formattedData['celana_kiper']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['celana_kiper']['file_tangkap_layar_celana_kiper']) }}"
            alt="">
    </div>
    @endif
    @if(isset($formattedData['celana_1']))
    <div class="containerKeteranganLengkap1">
        <img style="margin-top: 100px; margin-left: 20px; width: 700px; height: 700px; transform: rotate(90deg);"
            src="{{ public_path('storage/'. $formattedData['celana_1']['file_tangkap_layar_celana_1']) }}" alt="">
    </div>
    @endif --}}
</body>

</html>