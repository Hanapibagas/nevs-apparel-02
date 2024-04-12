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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Mesin Atexco</h4>

        <div class="card">
            <h5 class="card-header">Data disainer di mesin atexco</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table" id="atexco">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mesin</th>
                                <th>Nama Desainer</th>
                                <th>Nama Tim</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $mesin as $key => $mesins )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong style="text-transform: uppercase">
                                        {{ $mesins->User->name }}
                                    </strong>
                                </td>
                                <td><strong style="text-transform: uppercase">{{ $mesins->Users->name }}</strong></td>
                                <td><strong style="text-transform: uppercase">{{ $mesins->BarangMasukDisainer->nama_tim
                                        }}</strong></td>
                                <td>
                                    <span class="badge bg-label-{{ $mesins->status == 1 ? 'success' : 'danger' }}">
                                        {{ $mesins->status == 1 ? 'SELESAI' : 'PANDING' }}
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
    new DataTable('#atexco');
</script>
@endpush