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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Layout</h4>
        <div class="card">
            <h5 class="card-header">Data dari CS</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="cs" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>no.order</th>
                                <th>nama tim</th>
                                <th>nama Cs</th>
                                <th>sisa waktu produksi</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $oderCs as $key=> $disainers )
                            <tr>
                                <td></td>
                                <td>
                                    <strong style="text-transform: uppercase">{{ $disainers->BarangMasukCsLK->no_order
                                        }}</strong>
                                </td>
                                <td>
                                    <strong style="text-transform: uppercase">{{
                                        $disainers->BarangMasukCsLK->BarangMasukDisainer->nama_tim
                                        }}</strong>
                                </td>
                                <td>
                                    <strong style="text-transform: uppercase">{{
                                        $disainers->BarangMasukCsLK->UsersOrder->name
                                        }}</strong>
                                </td>
                                <td>
                                    <script>
                                        var deadlineDate = new Date("{{ $disainers->deadline }}");
                                        var currentDate = new Date();
                                        var elapsedDays = Math.floor((currentDate - deadlineDate) / (1000 * 60 * 60 * 24));
                                        if (elapsedDays > 0) {
                                            document.write('<span class="badge bg-label-danger">' + elapsedDays + ' hari terlewatkan</span>');
                                        } else if (elapsedDays === 0) {
                                            document.write('<span class="badge bg-label-danger">Hari ini adalah batas waktu</span>');
                                        } else {
                                            var remainingDays = Math.ceil((-elapsedDays));
                                            document.write('<span class="badge bg-label-success">Sisa ' + remainingDays + ' hari</span>');
                                        }
                                    </script>
                                </td>
                                <td>
                                    <a target="_blank"
                                        href="{{ route('getCetakDataLkLayout', $disainers->BarangMasukCsLK->id) }}"
                                        class="btn btn-danger">
                                        <i class="menu-icon tf-icons bx bxs-file-pdf"></i>Download LK</a>
                                    <a href="storage/{{ $disainers->BarangMasukCsLK->file_corel_disainer }}"
                                        class="btn btn-success" download>
                                        <i class="menu-icon tf-icons bx bxs-download"></i>Download File Corel</a>
                                    <a href="{{ route('getCreateLaporanLkLayout' , $disainers->id) }}"
                                        class="btn btn-info">
                                        <i class="menu-icon tf-icons bx bxs-inbox"></i>Input Laporan</a>
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

<script>
    // Mendapatkan tabel
    var table = document.getElementById('cs');

    // Mendapatkan baris pada tabel kecuali baris header
    var rows = Array.from(table.querySelectorAll('tbody tr'));

    // Mengurutkan baris berdasarkan sisa waktu produksi terendah ke tertinggi
    rows.sort(function (a, b) {
        var timeA = getTimeFromRow(a);
        var timeB = getTimeFromRow(b);

        return timeA - timeB;
    });

    // Menghapus baris yang ada di dalam tabel
    rows.forEach(function (row) {
        table.querySelector('tbody').appendChild(row);
    });

    // Fungsi untuk mendapatkan waktu dari sebuah baris
    function getTimeFromRow(row) {
        var timeText = row.querySelector('td:nth-child(4) span').innerText;
        var time = parseInt(timeText.split(' ')[1]);
        return time;
    }
</script>

@endpush
