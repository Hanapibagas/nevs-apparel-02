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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Press Kain</h4>

        <div class="card">
            <h5 class="card-header">Data masuk press kain</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>nama timr</th>
                                <th>no.order</th>
                                <th>Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $dataMasuk as $key => $mesins )
                            <tr>
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
                                    <strong style="text-transform: uppercase">{{ strftime("%A, %e %B %Y",
                                        strtotime($mesins->selesai)) }}</strong>
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
