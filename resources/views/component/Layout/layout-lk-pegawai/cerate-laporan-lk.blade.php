@extends('layouts.app')

@section('content')
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Input data laporan LK
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Input </span>data laporan</h4>
                    <form id="submissionForm" action="{{ route('putLaporanLs', $dataLk->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataLk->BarangMasukCsLK->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number" name="panjang_kertas"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number" name="poly"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input required class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layout" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Tangkap Laar</label>
                                                <input required class="form-control" type="file"
                                                    accept=".jpg, .png, .jepg" name="file_tangkap_layar"
                                                    id="lastName" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="submitButton" type="submit" class="btn btn-primary">
                            <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                            Input Laporan LK
                        </button>
                        <a href="{{ route('getIndexLkLayoutPegawai') }}" class="btn btn-outline-secondary"><i
                                class="menu-icon tf-icons bx bx-undo"></i>Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.getElementById('submissionForm').addEventListener('submit', function () {
        document.getElementById('submitButton').setAttribute('disabled', 'true');
        var icon = document.getElementById('submitIcon');
        icon.classList.remove('bx-send');
        icon.classList.add('bx-loader');
    });
</script>
@endpush
