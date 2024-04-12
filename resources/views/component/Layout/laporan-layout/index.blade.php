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
            <h5 class="card-header">Data laporan LK </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="cs" class="table">
                        <thead>
                            <tr>
                            <tr>
                                <th>No</th>
                                <th>no.order</th>
                                <th>nama tim</th>
                                <th>nama Layout</th>
                                <th>status</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $oderCs as $key => $disainers )
                            <tr>
                                <td>{{ $key+1 }}</td>
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
                                    <strong style="text-transform: uppercase">{{ $disainers->UserLayout->name
                                        }}</strong>
                                </td>
                                <td>
                                    <span style="text-transform: uppercase"
                                        class="badge bg-label-{{ $disainers->tanda_telah_mengerjakan == 1 ? 'success' : 'warning'}}">
                                        {{ $disainers->tanda_telah_mengerjakan == 1 ? 'Selesai' : 'Pending'}}
                                    </span>
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
