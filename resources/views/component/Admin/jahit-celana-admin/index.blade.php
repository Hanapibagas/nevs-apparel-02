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

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account Settings /</span> Pegawai Jahit Celana
    </h4>

    <h4 class="fw-bold py-3 mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
            Tambah Pengawai Jahit Celana
        </button>
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Form penambahan pegawai jahit celana</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('postCreateDesainer') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Nama Pegawai</label>
                                    <input name="name" type="text" id="nameWithTitle" class="form-control"
                                        placeholder="Silahkan masukkan nama ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Asal Kota Pegawai</label>
                                    <select id="country" name="asal_kota" class="select2 form-select">
                                        <option value="">-- Kota Produksi --</option>
                                        <option value="makassar">Makassar</option>
                                        <option value="jakarta">Jakarta</option>
                                        <option value="surabaya">Surabaya</option>
                                        <option value="bandung">Bandung</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Email Pegawai</label>
                                    <input name="email" type="text" id="nameWithTitle" class="form-control"
                                        placeholder="Silahkan masukkan email ..." />
                                    <input type="hidden" name="roles" value="jahit_celana">
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
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Daftar Pegawai Jahit Celana</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless border-bottom">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Nama pegawai</th>
                                <th class="text-nowrap">Asal pegawai</th>
                                <th class="text-nowrap text-center">Edit</th>
                                <th class="text-nowrap text-center">Hapus</th>
                                <th class="text-nowrap text-center">Updload</th>
                                <th class="text-nowrap text-center">Show</th>
                            </tr>
                        </thead>
                        <form method="POST" action="{{ route('postPirmission') }}">
                            @csrf
                            <tbody>
                                @foreach ($userJahitCelana as $user)
                                <tr>
                                    <td class="text-nowrap">{{ $user->name }}</td>
                                    <td class="text-nowrap">{{ $user->asal_kota }}</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input type="hidden" name="permission_edit[{{ $user->id }}]" value="off">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck1"
                                                name="permission_edit[{{ $user->id }}]" {{ $user->permission_edit == 1 ?
                                            'checked' : '' }} />
                                            <input type="hidden" value="{{ $user->id }}" name="id[]">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input type="hidden" name="permission_hapus[{{ $user->id }}]" value="off">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck2"
                                                name="permission_hapus[{{$user->id}}]" {{ $user->permission_hapus == 1 ?
                                            'checked' : '' }} />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input type="hidden" name="permission_create[{{ $user->id }}]" value="off">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck3"
                                                name="permission_create[{{ $user->id }}]" {{ $user->permission_create ==
                                            1 ?
                                            'checked' : '' }} />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input type="hidden" name="permission_show[{{ $user->id }}]" value="off">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck3"
                                                name="permission_show[{{ $user->id }}]" {{ $user->permission_show ==
                                            1 ?
                                            'checked' : '' }} />
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <button style="margin-left: 82%; margin-bottom: 30px" type="submit"
                                class="btn btn-primary">Simpan</button>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
