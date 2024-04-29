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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Data Order</h4>
        <div class="card">
            <h5 class="card-header">Data dari tim disainer </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="cs" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>no.order</th>
                                <th>nama tim</th>
                                <th>nama disainer</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $oderCs as $key => $disainers )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong style="text-transform: uppercase">
                                        {{ $disainers->no_order }}
                                    </strong>
                                </td>
                                <td><strong style="text-transform: uppercase">{{
                                        $disainers->BarangMasukDisainer->nama_tim }}</strong></td>
                                <td><strong style="text-transform: uppercase">{{ $disainers->Users->name }}</strong>
                                </td>
                                <td>
                                    @if (Auth::user()->permission_create == 1)
                                    @if ($disainers->aksi == 0)
                                    <a href="{{ route('getCreateToLkPegawai', $disainers->id) }}"
                                        class="btn btn-primary">
                                        <i class="menu-icon tf-icons bx bx-pencil"></i>
                                        Buat LK</a>
                                    @elseif ($disainers->aksi == 1)
                                    <button type="button" class="btn btn-warning">
                                        <i class="menu-icon tf-icons bx bx-show"></i>
                                        Lihat Detail</button>
                                    @endif
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
@endpush
