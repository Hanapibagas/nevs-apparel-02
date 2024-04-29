@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
@endpush

@section('content')
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text : "{{ session('success') }}",
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    })
</script>
@endif


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Details Laporan</h4>

        <div class="card">
            <h5 class="card-header">Details Lapran Layout</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>no</th>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Status</th>
                                <th>Nama layout</th>
                                <th>Panjang kertas</th>
                                <th>Panjang poly/DTF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporans as $key => $laporan)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporan->BarangMasukLayout->deadline)->format('Y-m-d') }}
                                </td>
                                <td>
                                    @if ($laporan->BarangMasukLayout->selesai)
                                    {{ \Carbon\Carbon::parse($laporan->BarangMasukLayout->selesai)->format('Y-m-d') }}
                                    @else
                                    Belum Selesai
                                    @endif
                                </td>
                                <td>
                                    @php
                                    $deadline = \Carbon\Carbon::parse($laporan->BarangMasukLayout->deadline);
                                    $selesai = $laporan->BarangMasukLayout->selesai ?
                                    \Carbon\Carbon::parse($laporan->BarangMasukLayout->selesai) : null;
                                    if ($selesai) {
                                    $selisihHari = $selesai->diffInDays($deadline);
                                    if ($selesai > $deadline) {
                                    echo "Lebih dari Deadline";
                                    } elseif ($selesai < $deadline) { echo "Kurang dari Deadline" ; } else {
                                        echo "Selesai tepat pada Deadline" ; } } else { echo "" ; } @endphp </td>
                                <td>{{ $laporan->BarangMasukLayout->nama_layout }}</td>
                                <td>{{ $laporan->BarangMasukLayout->panjang_kertas }}</td>
                                <td>{{ $laporan->BarangMasukLayout->panjang_poly_dtf }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <div class="card">
    <h5 class="card-header">Laporan Layout</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Deadline</th>
                <th>Selesai</th>
                <th>
                    @php
                    $deadline = \Carbon\Carbon::parse($laporan->BarangMasukLayout->deadline);
                    $selesai = $laporan->BarangMasukLayout->selesai ?
                    \Carbon\Carbon::parse($laporan->BarangMasukLayout->selesai) : null;
                    if ($selesai) {
                    $selisihHari = $selesai->diffInDays($deadline);
                    if ($selesai > $deadline) {
                    echo "<p>Lebih dari Deadline:</p>";
                    } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                        echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                <th>Nama layout</th>
                <th>Panjang kertas</th>
                <th>Panjang poly/DTF</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($laporan->BarangMasukLayout as $v )
                <td>
                    {{ \Carbon\Carbon::parse($laporan->BarangMasukLayout->deadline)->format('d F
                    Y') }}
                </td>
                <td>
                    @if($laporan->BarangMasukLayout->selesai)
                    {{ \Carbon\Carbon::parse($laporan->BarangMasukLayout->selesai)->format('d F
                    Y') }}
                    @else
                    @endif
                </td>
                <td>
                    @if ($selesai > $deadline)
                    +{{ $selisihHari }} hari
                    @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline @endif
                        </td>
                <td>
                    {{ strtoupper($laporan->BarangMasukLayout->UserLayout->name) }}
                </td>
                <td>
                    {{ $v->panjang_kertas }} Meter
                </td>
                <td>
                    {{ $v->poly }} Meter
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div> <br> --}}

{{-- @if(isset($laporan->BarangMasukMesinAtexco))
<div class="card">
    <h5 class="card-header">Laporan Atexco</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline =
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinAtexco->deadline);
                            $selesai = $laporan->BarangMasukMesinAtexco->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinAtexco->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>Nama penanggung jawab</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinAtexco->deadline)->format('d
                            F Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->selesai)
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinAtexco->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ isset($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@elseif(isset($laporan->BarangMasukMesinMimaki))
<div class="card">
    <h5 class="card-header">Laporan Mimaki</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline =
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinMimaki->deadline);
                            $selesai = $laporan->BarangMasukMesinMimaki->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinMimaki->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>Nama penanggung jawab</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinMimaki->deadline)->format('d
                            F Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->selesai)
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinMimaki->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ isset($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@endif

<div class="card">
    <h5 class="card-header">Laporan Press Kain</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline);
                            $selesai = $laporan->BarangMasukPressKain->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>kain</th>
                        <th>Berat</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukCs->Gambar->file_baju_player)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar) }}" alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_baju_pelatih)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_pelatih }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_pelatih }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_pelatih) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_baju_kiper)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_kiper }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_kiper }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_kiper) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_baju_1)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_1 }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_1 }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_1) }}" alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_celana_player)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_player }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_player }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_celana_player) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_celana_pelatih)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_pelatih }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_pelatih }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressKain->gambar_celana_pelatih) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_celana_kiper)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_kiper }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_kiper }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressKain->gambar_celana_kiper) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukCs->Gambar->file_celana_1)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if ($laporan->BarangMasukPressKain->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai)->format('d
                            F Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_1 }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_1 }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressKain->gambar_celana_1) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>

<div class="card">
    <h5 class="card-header">Laporan Cut</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukLaserCut->deadline);
                            $selesai = $laporan->BarangMasukLaserCut->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukLaserCut->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukLaserCut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukLaserCut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukLaserCut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->foto) }}" alt="" srcset="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><br>

<div class="card">
    <h5 class="card-header">Laporan Sortir</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukSortir->deadline);
                            $selesai = $laporan->BarangMasukSortir->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukSortir->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>No eror</th>
                        <th>Panjang kertas</th>
                        <th>Berat</th>
                        <th>Bahan</th>
                        <th>foto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukSortir->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukSortir->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukSortir->selesai)->format('d F
                            Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto) }}" alt="" srcset="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><br>

<div class="card">
    <h5 class="card-header">Laporan Jahit</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukJahitBaju->deadline);
                            $selesai = $laporan->BarangMasukJahitBaju->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukJahitBaju->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>Nama Penjahit</th>
                        <th>Foto serah</th>
                        <th>Foto terima</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukJahitBaju->deadline)->format('d F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukJahitBaju->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukJahitBaju->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan) }}" alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><br>

<div class="card">
    <h5 class="card-header">Laporan Finis</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukPressTag->deadline);
                            $selesai = $laporan->BarangMasukPressTag->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukPressTag->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; } else {
                                echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ; } @endphp </th>
                        <th>foto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressTag->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukPressTag->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukPressTag->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat pada Deadline
                                @endif </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto) }}" alt="" srcset="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div><br> --}}




@endsection

@push('js')
<script>
    new DataTable('#cs');
</script>
@endpush