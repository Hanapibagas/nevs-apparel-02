@extends('layouts.app')

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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Data fix disainer</h4>

        <div class="card">
            <h5 class="card-header">Data fix</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="ds" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tim</th>
                                <th>Nama CS</th>
                                <th>Nama mesin</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $disainer as $key => $disainers )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong style="text-transform: uppercase">
                                        {{ $disainers->nama_tim }}
                                    </strong>
                                </td>
                                <td><strong style="text-transform: uppercase">{{ $disainers->UsersCs->name }}</strong>
                                </td>
                                <td>
                                    @if ($disainers->DataMesinFix->isNotEmpty())
                                    <strong style="text-transform: uppercase">{{
                                        $disainers->DataMesinFix->first()->nama_mesin }}</strong>
                                    @else
                                    No DataMesinFix available
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ $disainers->tanda_telah_mengerjakan == 1 ? 'success' : 'danger' }}">
                                        {{ $disainers->tanda_telah_mengerjakan == 1 ? 'SELESAI' : 'PANDING' }}
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
    new DataTable('#ds');
</script>
@endpush