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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Disainer</h4>

        <div class="card">
            <h5 class="card-header">Data masuk dari CS</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="ds" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tim</th>
                                <th>Nama CS</th>
                                <th>aksi</th>
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
                                <td><strong style="text-transform: uppercase">{{ $disainers->Users->name }}</strong>
                                </td>
                                <td>
                                    @if ($disainers->aksi == 0)
                                    <a href="{{ route('getCreateToTeamMesinPegawai', $disainers->nama_tim) }}"
                                        class="btn btn-warning">
                                        <i class="menu-icon tf-icons bx bx-cog"></i>
                                        Kirim ke tim mesin</a>
                                    @elseif ($disainers->aksi == 1)
                                    <a href="{{ route('getUpdateToTeamMesin', $disainers->id) }}"
                                        class="btn btn-warning">
                                        <i class="menu-icon tf-icons bx bx-cog"></i>
                                        Kirim ke tim mesin</a>
                                    <a href="{{ route('getCreateToTeamCsPegawai', $disainers->nama_tim) }}"
                                        class="btn btn-primary">
                                        <i class="menu-icon tf-icons bx bx-headphone"></i>
                                        Kirim ke tim CS</a>
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
    new DataTable('#ds');
</script>
@endpush