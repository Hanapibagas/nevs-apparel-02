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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Details laporan</h4>

        @if ($laporans->whereNotNull('barang_masuk_layout_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk layout</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Nama layout</th>
                                <th>Panjang kertas</th>
                                <th>Panjang poly/DTF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanData['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['player'][0]['deadline'])->format('d F Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['player'][0]['selesai'])->format('d F Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['player'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['player'][0]['panjang_kertas_palayer'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['player'][0]['poly_player'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['pelatih'][0]['deadline'])->format('d F Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['pelatih'][0]['selesai'])->format('d F Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['pelatih'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['pelatih'][0]['panjang_kertas_pelatih'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['pelatih'][0]['poly_pelatih'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['kiper'][0]['deadline'])->format('d F Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['kiper'][0]['selesai'])->format('d F Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['kiper'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['kiper'][0]['panjang_kertas_kiper'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['kiper'][0]['poly_kiper'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['lk_1'][0]['deadline'])->format('d F Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['lk_1'][0]['selesai'])->format('d F Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['lk_1'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['lk_1'][0]['panjang_kertas_1'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['lk_1'][0]['poly_1'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['celana_player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['celana_player'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['celana_player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['celana_player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['celana_player'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['celana_player'][0]['panjang_kertas_celana_pelayer'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['celana_player'][0]['poly_celana_pelayer'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['celana_pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['celana_pelatih'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['celana_pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['celana_pelatih'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['celana_pelatih'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['celana_pelatih'][0]['panjang_kertas_celana_pelatih'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['celana_pelatih'][0]['poly_celana_pelatih'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['celana_kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['celana_kiper'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['celana_kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['celana_kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['celana_kiper'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['celana_kiper'][0]['panjang_kertas_celana_kiper'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['celana_kiper'][0]['poly_celana_kiper'] }} Meter
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanData['celana_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanData['celana_1'][0]['deadline'])->format('d F Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanData['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanData['celana_1'][0]['selesai'])->format('d F Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanData['celana_1'][0]['users_layout_id']) }}
                                </td>
                                <td>
                                    {{ $laporanData['celana_1'][0]['panjang_kertas_celana_1'] }} Meter
                                </td>
                                <td>
                                    {{ $laporanData['celana_1'][0]['poly_celana_1'] }} Meter
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br>
        @endif

        @if ($laporans->whereNotNull('barang_masuk_mesin_atexco_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk atexco</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Nama penanggung jawab</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataAtexco['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['player'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['player'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['player'][0]['file_foto']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['pelatih'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['pelatih'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['pelatih'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['pelatih'][0]['file_foto_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['kiper'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['kiper'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['kiper'][0]['file_foto_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['lk_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['lk_1'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['lk_1'][0]['file_foto_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataAtexco['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataAtexco['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['celana_player'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['celana_player'][0]['file_foto_celana_player']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataAtexco['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataAtexco['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['celana_pelatih'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['celana_pelatih'][0]['file_foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataAtexco['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataAtexco['celana_kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['celana_kiper'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['celana_kiper'][0]['file_foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataAtexco['celana_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['celana_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataAtexco['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataAtexco['celana_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataAtexco['celana_1'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataAtexco['celana_1'][0]['file_foto_celana_1']) }}"
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

        @if ($laporans->whereNotNull('barang_masuk_mesin_mimaki_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk mimaki</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Nama penanggung jawab</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataMimaki['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['player'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['player'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['player'][0]['file_foto']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['pelatih'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['pelatih'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['pelatih'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['pelatih'][0]['file_foto_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['kiper'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['kiper'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['kiper'][0]['file_foto_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['lk_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['lk_1'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['lk_1'][0]['file_foto_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataMimaki['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataMimaki['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['celana_player'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['celana_player'][0]['file_foto_celana_player']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataMimaki['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataMimaki['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['celana_pelatih'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['celana_pelatih'][0]['file_foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataMimaki['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataMimaki['celana_kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['celana_kiper'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['celana_kiper'][0]['file_foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataMimaki['celana_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['celana_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataMimaki['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataMimaki['celana_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataMimaki['celana_1'][0]['penanggung_jawab_id']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataMimaki['celana_1'][0]['file_foto_celana_1']) }}"
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

        @if ($laporans->whereNotNull('barang_masuk_presskain_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk press kain</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>kain</th>
                                <th>Berat</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataPressKain['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['player'][0]['kain'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['player'][0]['berat'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['player'][0]['gambar']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['pelatih'][0]['kain_pelatih'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['pelatih'][0]['berat_pelatih'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['pelatih'][0]['gambar_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['kiper'][0]['kain_kiper'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['kiper'][0]['berat_kiper'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['kiper'][0]['gambar_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['lk_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['lk_1'][0]['kain_1'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['lk_1'][0]['berat_1'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['lk_1'][0]['gambar_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_player'][0]['kain_celana_player'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_player'][0]['berat_celana_player'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['celana_player'][0]['gambar_celana_player']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_pelatih'][0]['kain_celana_pelatih'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_pelatih'][0]['berat_celana_pelatih'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['player'][0]['gambar_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_kiper'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_kiper'][0]['kain_celana_kiper'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_kiper'][0]['berat_celana_kiper'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['celana_kiper'][0]['gambar_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataPressKain['celana_1']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataPressKain['celana_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataPressKain['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataPressKain['celana_1'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_1'][0]['kain_celana_1'] }}
                                </td>
                                <td>
                                    {{ $laporanDataPressKain['celana_1'][0]['berat_celana_1'] }} Kg
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataPressKain['celana_1'][0]['gambar_celana_1']) }}"
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

        @if ($laporans->whereNotNull('barang_masuk_lasercut_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk laser cut</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataLaserCut['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['player'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['player'][0]['file_foto']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['pelatih'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['pelatih'][0]['file_foto_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['kiper'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['kiper'][0]['file_foto_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['lk_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['lk_1'][0]['file_foto_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataLaserCut['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataLaserCut['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['celana_player'][0]['file_foto_celana_player']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataLaserCut['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataLaserCut['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['celana_pelatih'][0]['file_foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataLaserCut['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataLaserCut['celana_kiper'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['celana_kiper'][0]['file_foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataLaserCut['celana_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['celana_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataLaserCut['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataLaserCut['celana_1'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataLaserCut['celana_1'][0]['file_foto_celana_1']) }}"
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

        @if ($laporans->whereNotNull('barang_masuk_manualcut_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk manual cut</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataManualCut['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['player'][0]['file_foto']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['pelatih'][0]['file_foto_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['kiper'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['kiper'][0]['file_foto_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['lk_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['lk_1'][0]['file_foto_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['celana_player'][0]['file_foto_celana_player']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['celana_pelatih'][0]['file_foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_kiper'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['celana_kiper'][0]['file_foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_1']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataManualCut['celana_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataManualCut['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataManualCut['celana_1'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataManualCut['celana_1'][0]['file_foto_celana_1']) }}"
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

        @if ($laporans->whereNotNull('barang_masuk_sortir_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk sortir</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>No eror</th>
                                <th>Panjang kertas</th>
                                <th>Berat</th>
                                <th>Bahan</th>
                                <th>foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataSortir['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['player'][0]['no_error']) }}
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['player'][0]['panjang_kertas']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['player'][0]['berat']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['player'][0]['bahan']) }} Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['player'][0]['foto']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['pelatih'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['pelatih'][0]['no_error_pelatih_pelatih_kiper_1'])
                                    }}
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['pelatih'][0]['panjang_kertas_pelatih_kiper_1']) }}
                                    Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['pelatih'][0]['berat_pelatih_kiper_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['pelatih'][0]['bahan_pelatih_kiper_1']) }} Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['pelatih'][0]['foto_pelatih_kiper_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['kiper'][0]['no_error_kiper_1']) }}
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['kiper'][0]['panjang_kertas_kiper_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['kiper'][0]['berat_kiper_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['kiper'][0]['bahan']) }} Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['kiper'][0]['foto_kiper_1']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['lk_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['lk_1'][0]['no_error_1']) }}
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['lk_1'][0]['panjang_kertas_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['lk_1'][0]['berat_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['lk_1'][0]['bahan_1']) }} Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['lk_1'][0]['foto_1']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataSortir['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataSortir['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_player'][0]['no_error_celana_pelayer']) }}
                                </td>
                                <td>
                                    {{
                                    strtoupper($laporanDataSortir['celana_player'][0]['panjang_kertas_celana_pelayer'])
                                    }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_player'][0]['berat_celana_pelayer']) }}
                                    Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_player'][0]['bahan_celana_pelayer']) }}
                                    Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['celana_player'][0]['foto_celana_pelayer']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataSortir['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataSortir['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_pelatih'][0]['no_error_celana_pelatih']) }}
                                </td>
                                <td>
                                    {{
                                    strtoupper($laporanDataSortir['celana_pelatih'][0]['panjang_kertas_celana_pelatih'])
                                    }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_pelatih'][0]['berat_celana_pelatih']) }}
                                    Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_pelatih'][0]['bahan_celana_pelatih']) }}
                                    Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['celana_pelatih'][0]['foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataSortir['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataSortir['celana_kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_kiper'][0]['no_error_celana_kiper']) }}
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_kiper'][0]['panjang_kertas_celana_kiper'])
                                    }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_kiper'][0]['berat_celana_kiper']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_kiper'][0]['bahan_celana_kiper']) }} Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['celana_kiper'][0]['foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['celana_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataSortir['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataSortir['celana_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_1'][0]['no_error_celana_1']) }}
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_1'][0]['panjang_kertas_celana_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_1'][0]['berat_celana_1']) }} Meter
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataSortir['celana_1'][0]['bahan_celana_1']) }} Meter
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataSortir['celana_1'][0]['foto_celana_1']) }}"
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

        @if ($laporans->whereNotNull('jahit_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk jahit</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>Nama Penjahit</th>
                                <th>Foto serah</th>
                                <th>Foto terima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataJahit['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['player'][0]['leher']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['player'][0]['pola_badan']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['player'][0]['foto']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['pelatih'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['pelatih'][0]['leher_pelatih']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['pelatih'][0]['pola_badan_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['pelatih'][0]['foto_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['kiper'][0]['leher_kiper']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['kiper'][0]['pola_badan_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['kiper'][0]['foto_kiper']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['lk_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['lk_1'][0]['leher_1']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['lk_1'][0]['pola_badan_lk_1']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['lk_1'][0]['foto_lk_1']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataJahit['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataJahit['celana_player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['celana_player'][0]['leher_celana_pelayer']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_player'][0]['pola_badan_celana_pelayer']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_player'][0]['foto_celana_pelayer']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataJahit['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataJahit['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['celana_pelatih'][0]['leher_celana_pelatih']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_pelatih'][0]['pola_badan_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_pelatih'][0]['foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataJahit['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['celana_kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['celana_kiper'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['celana_kiper'][0]['leher_celana_kiper']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_kiper'][0]['pola_badan_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_kiper'][0]['foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataManualCut['celana_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['celana_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataJahit['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataJahit['celana_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    {{ strtoupper($laporanDataJahit['celana_1'][0]['leher_celana_1']) }}
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_1'][0]['pola_badan_celana_1']) }}"
                                        alt="" srcset="">
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataJahit['celana_1'][0]['foto_celana_1']) }}"
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

        @if ($laporans->whereNotNull('finis_id')->count() > 0)
        <div class="card">
            <h5 class="card-header">Data masuk layout</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>Deadline</th>
                                <th>Selesai</th>
                                <th>foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($laporanDataFinis['player']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['player'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['player'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['player'][0]['foto']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['pelatih']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['pelatih'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['pelatih'][0]['foto_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['kiper']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['kiper'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['kiper'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['kiper'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['kiper'][0]['foto_kiper']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['lk_1']))
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['lk_1'][0]['deadline'])->format('d F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['lk_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['lk_1'][0]['selesai'])->format('d F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['lk_1'][0]['foto_1']) }}" alt=""
                                        srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['celana_player']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_player'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['celana_player'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_player'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['celana_player'][0]['foto_celana_pelayer']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['celana_pelatih']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_pelatih'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['celana_pelatih'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_pelatih'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['celana_pelatih'][0]['foto_celana_pelatih']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['celana_kiper']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_kiper'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['celana_kiper'][0]['selesai'])
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_kiper'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['celana_kiper'][0]['foto_celana_kiper']) }}"
                                        alt="" srcset="">
                                </td>
                            </tr>
                            @endif
                            @if (!empty($laporanDataFinis['celana_1']))
                            <tr>
                                <td>
                                    {{
                                    \Carbon\Carbon::parse($laporanDataFinis['celana_1'][0]['deadline'])->format('d
                                    F
                                    Y')
                                    }}
                                </td>
                                <td>
                                    @if($laporanDataFinis['celana_1'][0]['selesai'])
                                    {{ \Carbon\Carbon::parse($laporanDataFinis['celana_1'][0]['selesai'])->format('d
                                    F
                                    Y')
                                    }}
                                    @else
                                    <!-- Tidak ada yang ditampilkan -->
                                    @endif
                                </td>
                                <td>
                                    <img style="height: 200px; width: 200px"
                                        src="{{ asset('storage/'.$laporanDataFinis['celana_1'][0]['foto_celana_1']) }}"
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

    </div>
</div>

@endsection

@push('js')
<script>
    new DataTable('#cs');
</script>
@endpush
