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
            <h5 class="card-header">Data masuk dari Disainer</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="atexco" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Desainer</th>
                                <th>Status</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $mesin as $key => $mesins )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong style="text-transform: uppercase">
                                        {{ $mesins->Users->name }}
                                    </strong>
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $mesins->status == 1 ? 'success' : 'warning'}}">
                                        {{ $mesins->status == 1 ? 'Selesai' : 'Pending'}}
                                    </span>
                                </td>
                                <td>
                                    <a data-bs-toggle="modal" data-bs-target="#modalCenter{{ $mesins->id }}"
                                        style="cursor: pointer; text-decoration: none; color: white"
                                        class="btn btn-warning">
                                        <i class="menu-icon tf-icons bx bx-show"></i>
                                        Detail</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalCenter{{ $mesins->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('putFeedbackByAtexcoPegawai', $mesins->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Detail Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">nama mesin</label>
                                                        <input type="text" id="nameWithTitle" class="form-control"
                                                            value="{{ $mesins->nama_mesin  }}" readonly />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">nama
                                                            desain</label>
                                                        <input type="text" id="nameWithTitle" class="form-control"
                                                            value="{{ $mesins->BarangMasukDisainer->nama_tim  }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">keterangan</label>
                                                        <textarea id="basic-default-message" class="form-control"
                                                            readonly>{{ $mesins->keterangan  }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">status</label>
                                                        <select name="status" class="form-control">
                                                            <option selected>{{
                                                                $mesins->status == 1 ? 'SELESAI' : 'PENDING' }}</option>
                                                            <option value="0">-------------</option>
                                                            <option value="1">SELESAI</option>
                                                            <option value="0">PENDING</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">file
                                                            disain</label><br>
                                                        {{-- <img style="width: 100%;"
                                                            src="{{ Storage::url($mesins->file) }}" alt=""
                                                            srcset=""><br><br> --}}
                                                        <img style="width: 100%;"
                                                            src="{{ asset('storage/'.$mesins->file) }}" alt=""
                                                            srcset=""><br><br>
                                                        <a href="storage/{{ $mesins->file }}" download=""
                                                            class="btn rounded-pill btn-secondary">Download</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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