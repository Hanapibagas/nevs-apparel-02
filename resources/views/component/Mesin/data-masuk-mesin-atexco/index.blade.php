@extends('layouts.app')

@push('css')

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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Mesin</h4>

        <div class="card">
            <h5 class="card-header">Data masuk dari Layout</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>nama tim</th>
                                <th>no.order</th>
                                <th>sisa waktu produksi</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $dataMasuk as $key => $mesins )
                            <tr>
                                <td></td>
                                <td>
                                    <strong style="text-transform: uppercase">{{
                                        $mesins->BarangMasukCs->BarangMasukDisainer->nama_tim
                                        }}</strong>
                                </td>
                                <td>
                                    <strong style="text-transform: uppercase">{{ $mesins->BarangMasukCs->no_order
                                        }}</strong>
                                </td>
                                <td>
                                    <script>
                                        var deadlineDate = new Date("{{ $mesins->deadline }}");
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
                                        href="{{ route('getCetakDataLkAtxco', $mesins->BarangMasukLayout->barang_masuk_id) }}"
                                        class="btn btn-danger">
                                        <i class="menu-icon tf-icons bx bxs-file-pdf"></i>Show LK</a>
                                    @if ($mesins->BarangMasukLayout->file_corel_layout)
                                    <a href="storage/{{ $mesins->BarangMasukLayout->file_corel_layout }}"
                                        class="btn btn-success" download>
                                        <i class="menu-icon tf-icons bx bxs-download"></i>Download File RAR</a>
                                    @elseif ($mesins->BarangMasukLayout->keterangan1)
                                    <a style="color: white" class="btn btn-success">
                                        <i class="menu-icon tf-icons bx bxs-ban"></i>Tidak memiliki file corel</a>
                                    @endif
                                    @if (Auth::user()->permission_create == 1)
                                    <a href="{{ route('getInputLaporanAtxco' , $mesins->no_order_id) }}"
                                        class="btn btn-info">
                                        <i class="menu-icon tf-icons bx bxs-inbox"></i>Input Laporan</a>
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
    new DataTable('#atexco');
</script>
@endpush