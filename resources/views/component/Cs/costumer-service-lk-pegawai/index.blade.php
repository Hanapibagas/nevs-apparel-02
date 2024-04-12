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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Costumer Service</h4>
        <div class="card">
            <h5 class="card-header">Data LK </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="cs" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>no.order</th>
                                <th>nama tim</th>
                                <th>nama layout</th>
                                <th>waktu produksi</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        @php
                        function calculateWorkingDays($startDate, $endDate) {
                        $start = new DateTime($startDate);
                        $end = new DateTime($endDate);
                        $interval = DateInterval::createFromDateString('1 day');
                        $period = new DatePeriod($start, $interval, $end);
                        $workingDays = 0;
                        foreach ($period as $day) {
                        if ($day->format('w') != 0) {
                        $workingDays++;
                        }
                        }
                        return $workingDays;
                        }
                        @endphp
                        <tbody>
                            @foreach ( $oderCs as $key => $disainers )
                            <tr>
                                <td></td>
                                <td>{{ $disainers->no_order }}</td>
                                <td>{{ $disainers->BarangMasukDisainer->nama_tim }}</td>
                                <td> {{ $disainers->UsersLk->name }} </td>
                                <td>
                                    {{
                                    calculateWorkingDays($disainers->tanggal_masuk, $disainers->deadline) }} Hari
                                    @php
                                    $totalDays = calculateWorkingDays($disainers->tanggal_masuk,
                                    $disainers->deadline);
                                    $status = ($totalDays < 10) ? '<span class="badge bg-label-danger">Express</span>'
                                        : '<span class="badge bg-label-warning">Normal</span>' ; @endphp {!! $status !!}
                                        </td>
                                <td>
                                    @if ($disainers->aksi == 0)
                                    <a href="{{ route('getCreateToLkPegawai', $disainers->id) }}"
                                        class="btn btn-primary">
                                        <i class="menu-icon tf-icons bx bx-pencil"></i>
                                        Edit LK</a>
                                    @elseif ($disainers->aksi == 1)
                                    <a href="{{ route('getEditIndexLkCsPegawai', $disainers->id) }}"
                                        class="btn btn-primary">
                                        <i class="menu-icon tf-icons bx bx-pencil"></i>
                                        Edit LK</a>
                                    <a target="_blank" href="{{ route('getCetakDataLk', $disainers->id) }}"
                                        class="btn btn-danger">
                                        <i class="menu-icon tf-icons bx bxs-file-pdf"></i>Download PDF LK</a>
                                    @endif
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
    document.addEventListener('DOMContentLoaded', function () {
        var tableBody = document.querySelector('#cs tbody');
        var rows = Array.from(tableBody.querySelectorAll('tr'));

        rows.sort(function (a, b) {
            var timeA = parseInt(a.cells[4].textContent);
            var timeB = parseInt(b.cells[4].textContent);

            return timeA - timeB;
        });

        rows.forEach(function (row) {
            tableBody.appendChild(row);
        });
    });
</script>
@endpush