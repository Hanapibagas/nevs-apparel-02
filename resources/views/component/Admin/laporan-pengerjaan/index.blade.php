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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Laporan</h4>
        <div class="card">
            <h5 class="card-header">Data keseluruhan laporan </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="cs" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>no.inv</th>
                                <th>no.po</th>
                                <th>Nama tim</th>
                                <th>nama admin</th>
                                <th>Status</th>
                                <th>deadline</th>
                                <th>sisa waktu</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            usort($laporans, function($a, $b) {
                            $deadlineA = \Carbon\Carbon::parse($a->BarangMasukCs->deadline);
                            $deadlineB = \Carbon\Carbon::parse($b->BarangMasukCs->deadline);
                            $today = \Carbon\Carbon::now();

                            $diffA = $deadlineA->diffInDays($today);
                            $diffB = $deadlineB->diffInDays($today);

                            return $diffA <=> $diffB; // Mengurutkan secara ascending
                                });
                                @endphp
                                @foreach ( $laporans as $key => $laporan )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><strong style="text-transform: uppercase">{{ $laporan->BarangMasukCs->no_nota
                                            }}</strong></td>
                                    <td><strong style="text-transform: uppercase">{{ $laporan->BarangMasukCs->no_order
                                            }}</strong></td>
                                    <td><strong style="text-transform: uppercase">{{
                                            $laporan->BarangMasukCs->BarangMasukDisainer->nama_tim }}</strong></td>
                                    <td><strong style="text-transform: uppercase">{{
                                            $laporan->BarangMasukCs->UsersOrder->name }}</strong></td>
                                    <td>
                                        @if ($laporan->status == 'Selesai')
                                        <span class="badge bg-success"> {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Layout')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Mesin Mimaki')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Mesin Atexco')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Press Kain')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Laser Cut')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Manual Cut')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Sortir')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        @elseif ($laporan->status == 'Jahit')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span>
                                        {{-- @elseif ($laporan->status == 'Selesai')
                                        <span class="badge bg-warning">Berada di {{ $laporan->status }}</span> --}}
                                        @endif
                                    </td>
                                    <td><strong style="text-transform: uppercase">{{
                                            \Carbon\Carbon::parse($laporan->BarangMasukCs->deadline)->format('d F Y')
                                            }}</strong></td>
                                    <td>
                                        @php
                                        $tanggal_masuk = \Carbon\Carbon::parse($laporan->BarangMasukCs->tanggal_masuk);
                                        $deadline = \Carbon\Carbon::parse($laporan->BarangMasukCs->deadline);

                                        $today = \Carbon\Carbon::now();

                                        if ($tanggal_masuk->gt($deadline)) {
                                        $totalHari = $tanggal_masuk->diffInDaysFiltered(function ($date) {
                                        return !$date->isSunday();
                                        }, $deadline) * -1;
                                        } else {
                                        $totalHari = $tanggal_masuk->diffInDaysFiltered(function ($date) {
                                        return !$date->isSunday();
                                        }, $deadline);
                                        }
                                        @endphp
                                        <p>
                                            @if ($totalHari < 0) <span class="badge bg-danger">{{ $totalHari }}
                                                Hari</span>
                                                @else
                                                <span class="badge bg-success">{{ $totalHari }} Hari</span>
                                                @endif
                                        </p>
                                    </td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ route('getCetakDataLkSuperAdmin', $laporan->BarangMasukLayout->barang_masuk_id) }}"
                                            class="btn btn-danger">
                                            <i class="menu-icon tf-icons bx bxs-file-pdf"></i>Show LK</a>
                                        <a class="btn btn-primary"
                                            href="{{ route('getDetailLaporan', $laporan->barang_masuk_costumer_services_id) }}"
                                            type="button" class="btn btn-warning">
                                            <i class="menu-icon tf-icons bx bx-show"></i>
                                            Lihat Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    new DataTable('#cs');
</script>
@endpush