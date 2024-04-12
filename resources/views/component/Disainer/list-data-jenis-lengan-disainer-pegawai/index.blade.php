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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Produksi</h4>
        <button style="margin-bottom: 20px;" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#modalCenter">
            Tambah data Produksi
        </button>
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Form tambah data Produksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('getCreateistDataJenisLengan') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Produksi</label>
                                    <input required name="jenis_kera" type="text" id="nameWithTitle"
                                        class="form-control" placeholder="Silahkan masukkan nama tim ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Aktifkan Komisi</label>
                                    <select required class="form-control" name="status" id="">
                                        <option value="-- Silahkan Pilih Aktifkan Komisi --">-- Silahkan Pilih Aktifkan
                                            Komisi --</option>
                                        <option value="0">Tidak Aktif</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">file Produksi</label>
                                    <input required name="gambar" type="file" id="nameWithTitle" class="form-control"
                                        placeholder="Silahkan masukkan nama tim ..." />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Data Produksi</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table id="ds" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produksi</th>
                                <th>Status Komisi</th>
                                <th>Gambar Produksi</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $jenisKerah as $key => $jenisKerahs )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong>
                                        {{ $jenisKerahs->jenis_kera }}
                                    </strong>
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $jenisKerahs->status == 1 ? 'success' : 'warning'}}">
                                        {{ $jenisKerahs->status == 1 ? 'Aktif' : 'Tidak Aktif'}}
                                    </span>
                                </td>
                                <td>
                                    <img style="width: 100px;" src="{{ asset('storage/'.$jenisKerahs->gambar) }}"
                                        alt="">
                                </td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#modalCenter{{ $jenisKerahs->id }}"
                                        class="btn btn-primary">
                                        <i class="menu-icon tf-icons bx bx-pencil"></i>
                                        Edit</button>
                                    <form method="POST"
                                        action="{{ route('deleteListDataJenisLengan', ['id' => $jenisKerahs->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="menu-icon tf-icons bx bx-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="modalCenter{{ $jenisKerahs->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCenterTitle">Form tambah data Produksi
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('putListDataJenisLengan', $jenisKerahs->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">Nama
                                                            Produksi</label>
                                                        <input required name="jenis_kera" type="text" id="nameWithTitle"
                                                            class="form-control" value="{{ $jenisKerahs->jenis_kera }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">Aktifkan
                                                            Komisi</label>
                                                        <select required class="form-control" name="status" id="">
                                                            <option value="{{ $jenisKerahs->status }}"> {{
                                                                $jenisKerahs->status == 1 ? 'Aktif' : 'Tidak Aktif'}}
                                                            </option>
                                                            <option value="-- Silahkan Pilih Aktifkan Komisi --">--
                                                                Silahkan Pilih Aktifkan
                                                                Komisi --</option>
                                                            <option value="0">Tidak Aktif</option>
                                                            <option value="1">Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col mb-3">
                                                        <label for="nameWithTitle" class="form-label">file
                                                            Produksi</label>
                                                        <input required name="gambar" type="file" id="nameWithTitle"
                                                            class="form-control"
                                                            placeholder="Silahkan masukkan nama tim ..." />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Tutup
                                                </button>
                                                <button type="submit" class="btn btn-primary">Simpan Data</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    $('.btn-danger').on('click', function (e) {
        e.preventDefault();
        var url = $(this).closest('form').attr('action');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire('Berhasil!', response.success, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function (response) {
                        Swal.fire('Gagal!', response.responseJSON.error, 'error');
                    }
                });
            }
        });
    });
});

</script>
<script>
    new DataTable('#ds');
</script>
@endpush