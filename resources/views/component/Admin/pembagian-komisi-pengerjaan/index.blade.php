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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Komisi</h4>
        <a href="{{ route('getPembagianKomisi') }}" style="margin-top: -20px; margin-bottom: 10px;"
            class="btn btn-outline-secondary"><i class="menu-icon tf-icons bx bx-undo"></i>Kembali</a>
        <div class="card">
            <h5 class="card-header">Data keseluruhan komisi
            </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="cs" class="table">
                        <thead>
                            <tr>
                                <th>asal kota</th>
                                <th>nama layout</th>
                                <th>Total Komisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $pembagianKomisiFiltered as $key => $laporan )
                            <tr>
                                <td>
                                    <strong style="text-transform: uppercase">{{
                                        $laporan->BarangMasukCs->kota_produksi
                                        }}</strong>
                                </td>
                                <td>
                                    <strong style="text-transform: uppercase">{{ $laporan->UserLayout->name
                                        }}</strong>
                                </td>
                                <td>
                                    <strong style="text-transform: uppercase">Rp.{{
                                        number_format($totalKomisiPerUser[$laporan->user_id], 0,',','.')
                                        }}</strong>
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