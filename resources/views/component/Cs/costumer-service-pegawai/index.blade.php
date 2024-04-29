@extends('layouts.app')

@push('css')
{{--
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" /> --}}
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
        @if (Auth::user()->permission_create == 1)
        <button style="margin-bottom: 20px;" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#modalCenter">
            Kirim data ke disainer
        </button>
        @endif
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Form pengiriman data ke tim disainer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('postKeTimDisainerPegawai') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Tim</label>
                                    <input required name="nama_tim" type="text" id="nameWithTitle" class="form-control"
                                        placeholder="Silahkan masukkan nama tim ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Disainer</label>
                                    <select name="users_id" aria-label="Default select example"
                                        id="exampleFormControlSelect1" class="form-select">
                                        <option selected>-- Silahkan Pilih Disainer --</option>
                                        @foreach ( $users as $user )
                                        <option required value="{{ $user->id }}">
                                            {{ $user->name }} sedang menangani desain {{
                                            isset($userCounts[$user->id]) ? $userCounts[$user->id]
                                            : 0 }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button type="submit" class="btn btn-primary">Kirim Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="text-center" id="loadingSpinner" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Loading...</p>
        </div>
        <div class="card">
            <h5 class="card-header">Data untuk tim disainer </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="desain" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>nama tim</th>
                                <th>nama disainer</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $disainer as $key => $disainers )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong>
                                        {{ $disainers->nama_tim }}
                                    </strong>
                                </td>
                                <td>{{ $disainers->Users->name }}</td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ isset($disainers->DataMesin[0]) && $disainers->DataMesin[0]->status == 1 ? 'success' : 'danger' }}">
                                        {{ isset($disainers->DataMesin[0]) && $disainers->DataMesin[0]->status == 1 ?
                                        'SELESAI' : 'PANDING' }}
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
    new DataTable('#desain');
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('form').submit(function () {
            $('#modalCenter').modal('hide');
            $('#loadingSpinner').show();
            $('button[type="submit"]').prop('disabled', true);
        });
    });
</script>
@endpush
