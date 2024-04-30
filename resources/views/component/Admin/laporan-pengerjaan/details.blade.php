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

{{--  --}}
@if(isset($laporan->BarangMasukMesinAtexco))
@if ($laporan->barang_masuk_mesin_atexco_id )
<div class="card">
    <h5 class="card-header">Laporan Atexco</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        {{-- <th>
                            @php
                            $deadline =
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinAtexco->deadline);
                            $selesai = $laporan->BarangMasukMesinAtexco->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinAtexco->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>Nama penanggung jawab</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukMesinAtexco->lk_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_celana_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_celana_player) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_celana_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_celana_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinAtexco->lk_celana_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinAtexco->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinAtexco->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinAtexco->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinAtexco->file_foto_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@endif
@elseif(isset($laporan->BarangMasukMesinMimaki))
@if ($laporan->barang_masuk_mesin_mimaki_id )
<div class="card">
    <h5 class="card-header">Laporan Mimaki</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        {{-- <th>
                            @php
                            $deadline =
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinMimaki->deadline);
                            $selesai = $laporan->BarangMasukMesinMimaki->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukMesinMimaki->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>Nama penanggung jawab</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukMesinMimaki->lk_player_id)
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
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td>
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_celana_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_celana_player) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_celana_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_celana_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukMesinMimaki->lk_celana_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            @if ($laporan->BarangMasukMesinMimaki->penanggung_jawab_id == null)
                            Belum melakukan pengisian data
                            @elseif ($laporan->BarangMasukMesinMimaki->UserMesinAtexco)
                            {{ strtoupper($laporan->BarangMasukMesinMimaki->UserMesinAtexco->name) }}
                            @endif
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukMesinMimaki->file_foto_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@endif
@endif

@if ($laporan->barang_masuk_presskain_id )
<div class="card">
    <h5 class="card-header">Laporan Press Kain</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        {{-- <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukPressKain->deadline);
                            $selesai = $laporan->BarangMasukPressKain->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukPressKain->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>kain</th>
                        <th>Berat</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukPressKain->lk_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressKain->lk_pelatih_id)
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
                            {{-- </td>
                        <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td>
                        <td> --}}
                            {{ $laporan->BarangMasukPressKain->kain_pelatih }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_pelatih }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressKain->lk_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_kiper }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_kiper }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressKain->lk_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_1 }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_1 }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ asset('storage/'.$laporan->BarangMasukPressKain->gambar_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressKain->file_foto_celana_player)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
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
                    @if ($laporan->BarangMasukPressKain->file_foto_celana_pelatih)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_pelatih }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_pelatih }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressKain->gambar_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressKain->file_foto_celana_kiper)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_kiper }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_kiper }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressKain->gambar_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressKain->file_foto_celana_1)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukPressKain->kain_celana_1 }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukPressKain->berat_celana_1 }} Kg
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressKain->gambar_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@endif

@if ($laporan->barang_masuk_lasercut_id )
<div class="card">
    <h5 class="card-header">Laporan Laser Cut</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        {{-- <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukLaserCut->deadline);
                            $selesai = $laporan->BarangMasukLaserCut->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukLaserCut->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukLaserCut->lk_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_celana_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_celana_player) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_celana_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_celana_kiper_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukLaserCut->lk_celana_1_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukLaserCut->file_foto_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@endif

@if ($laporan->barang_masuk_manualcut_id)
<div class="card">
    <h5 class="card-header">Laporan Manual Cut</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        {{-- <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline);
                            $selesai = $laporan->BarangMasukManualcut->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukManualcut->lk_player_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_pelatih_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_kiper_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_1_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_celana_player_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_celana_player) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_celana_pelatih_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_celana_kiper_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukManualcut->lk_celana_1_id)
                    <tr>
                        <td>
                            {{
                            \Carbon\Carbon::parse($laporan->BarangMasukManualcut->deadline)->format('d
                            F
                            Y') }}
                        </td>
                        <td>
                            @if($laporan->BarangMasukManualcut->selesai)
                            {{ \Carbon\Carbon::parse($laporan->BarangMasukManualcut->selesai)->format('d
                            F
                            Y') }}
                            @else
                            @endif
                        </td>
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukManualcut->file_foto_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>
@endif

<div class="card">
    <h5 class="card-header">Laporan Sortir</h5>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Deadline</th>
                        <th>Selesai</th>
                        {{-- <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukSortir->deadline);
                            $selesai = $laporan->BarangMasukSortir->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukSortir->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>No eror</th>
                        <th>Panjang kertas</th>
                        <th>Berat</th>
                        <th>Bahan</th>
                        <th>foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukSortir->lk_player_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
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
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_pelatih_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_pelatih }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_pelatih }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_pelatih }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_pelatih }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_kiper_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_kiper }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_kiper }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_kiper }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_kiper }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_kiper) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_1_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_1 }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_1 }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_1 }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_1 }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_1) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_celana_player_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_celana_pelayer }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_celana_pelayer }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_celana_pelayer }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_celana_pelayer }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_celana_pelayer) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_celana_pelatih_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_celana_pelatih }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_celana_pelatih }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_celana_pelatih }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_celana_pelatih }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_celana_kiper_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_celana_kiper }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_celana_kiper }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_celana_kiper }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_celana_kiper }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukSortir->lk_celana_1_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ $laporan->BarangMasukSortir->no_error_celana_1 }}
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->panjang_kertas_celana_1 }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->berat_celana_1 }} Meter
                        </td>
                        <td>
                            {{ $laporan->BarangMasukSortir->bahan_celana_1 }} Meter
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukSortir->foto_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
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
                        {{-- <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukJahitBaju->deadline);
                            $selesai = $laporan->BarangMasukJahitBaju->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukJahitBaju->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>Nama Penjahit</th>
                        <th>Foto serah</th>
                        <th>Foto terima</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukJahitBaju->lk_player_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_pelatih_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_pelatih) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_pelatih) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_pelatih) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_kiper_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_kiper) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_kiper) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_kiper) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_1_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_1) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_1) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_1) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_celana_player_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_celana_player) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_celana_player) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_celana_player) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_celana_pelatih_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_celana_pelatih) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_celana_pelatih) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_celana_kiper_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_celana_kiper) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_celana_kiper) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukJahitBaju->lk_celana_1_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            {{ strtoupper($laporan->BarangMasukJahitBaju->leher_celana_1) }}
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->pola_badan_celana_1) }}"
                                alt="" srcset="">
                        </td>
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukJahitBaju->foto_celana_1) }}"
                                alt="Belum melakukan terima barang" srcset="">
                        </td>
                    </tr>
                    @endif
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
                        {{-- <th>
                            @php
                            $deadline = \Carbon\Carbon::parse($laporan->BarangMasukPressTag->deadline);
                            $selesai = $laporan->BarangMasukPressTag->selesai ?
                            \Carbon\Carbon::parse($laporan->BarangMasukPressTag->selesai) : null;
                            if ($selesai) {
                            $selisihHari = $selesai->diffInDays($deadline);
                            if ($selesai > $deadline) {
                            echo "<p>Lebih dari Deadline:</p>";
                            } elseif ($selesai < $deadline) { echo "<p>Kurang dari Deadline</p>" ; }
                                else { echo "<p>Selesai tepat pada Deadline</p>" ; } } else { echo "" ;
                                } @endphp </th> --}}
                        <th>foto</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($laporan->BarangMasukPressTag->lk_player_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_pelatih_id)
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_kiper_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_1_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_1) }}" alt=""
                                srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_celana_player_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_celana_player) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_celana_pelatih_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_celana_pelatih) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_celana_kiper_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_celana_kiper) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                    @if ($laporan->BarangMasukPressTag->lk_celana_1_id )
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
                        {{-- <td>
                            @if ($selesai > $deadline)
                            +{{ $selisihHari }} hari
                            @elseif($selesai < $deadline) - {{ $selisihHari }} hari @else Selesai tepat
                                pada Deadline @endif </td> --}}
                        <td>
                            <img style="height: 200px; width: 200px"
                                src="{{ Storage::url($laporan->BarangMasukPressTag->foto_celana_1) }}"
                                alt="" srcset="">
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div><br>
{{--  --}}


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
