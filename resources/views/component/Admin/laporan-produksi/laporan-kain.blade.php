<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center">laporan Press Kain</h1>
    @php
    use Carbon\Carbon;
    $formattedDari = Carbon::parse($dari)->translatedFormat('d F Y');
    $formattedKe = Carbon::parse($ke)->translatedFormat('d F Y');
    @endphp
    <p style="text-align: center">Periode {{ $formattedDari }} / {{ $formattedKe }}</p>
    <hr>
    <table>
        <tbody>
            <tr>
                <th>Asal Daerah</th>
                <th>Nama kain</th>
                <th>Total kain</th>
            </tr>
        </tbody>
        <thead>
            @foreach ( $data as $q )
            <tr>
                <td>{{ $q->daerah }}</td>
                <td>{{ $q->Kain->nama }}</td>
                <td>{{ $q->total_kain }}</td>
            </tr>
            @endforeach
        </thead>
    </table>
    <h1 style="text-align: center; page-break-before: always;">laporan Cut Polos</h1>
    <p style="text-align: center">Periode {{ $formattedDari }} / {{ $formattedKe }}</p>
    <hr>
    <table>
        <tbody>
            <tr>
                <th>Asal Daerah</th>
                <th>Nama kain</th>
                <th>Total kain</th>
            </tr>
        </tbody>
        <thead>
            @foreach ( $cutPolos as $q )
            <tr>
                <td>{{ $q->daerah }}</td>
                <td>{{ $q->Kain->nama }}</td>
                <td>{{ $q->total_kain }}</td>
            </tr>
            @endforeach
        </thead>
    </table>
    <h1 style="text-align: center; page-break-before: always;">laporan Sortir</h1>
    <p style="text-align: center">Periode {{ $formattedDari }} / {{ $formattedKe }}</p>
    <hr>
    <table>
        <tbody>
            <tr>
                <th>Asal Daerah</th>
                <th>Nama kain</th>
                <th>Total kain</th>
            </tr>
        </tbody>
        <thead>
            @foreach ( $sortir as $q )
            <tr>
                <td>{{ $q->daerah }}</td>
                <td>{{ $q->Kain->nama }}</td>
                <td>{{ $q->total_kain }}</td>
            </tr>
            @endforeach
        </thead>
    </table>
</body>

</html>
