@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Input data laporan Press Kain
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Input </span>data laporan</h4>
                    <form id="submissionForm" action="{{ route('putLaporanPreskain', $dataMasuk->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_baju_player)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_baju_pelatih)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_pelatih" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_pelatih" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_pelatih" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_baju_kiper)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_kiper" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_kiper" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_kiper" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_baju_1)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_1" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_1" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_celana_player)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_celana_player" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_celana_player" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_celana_player" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_celana_pelatih)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_celana_pelatih" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_celana_pelatih" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_celana_pelatih" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_celana_kiper)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_celana_kiper" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_celana_kiper" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_celana_kiper" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($dataMasuk->BarangMasukCs->Gambar->file_celana_1)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName"
                                                    value="{{ $dataMasuk->BarangMasukCs->no_order }}" readonly
                                                    autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Kain</label>
                                                <input required placeholder="Contoh: ABCD" class="form-control"
                                                    type="text" id="firstName" name="kain_celana_1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat</label>
                                                <input required class="form-control" placeholder="Contoh: 1 Kg"
                                                    type="text" id="firstName" name="berat_celana_1" autofocus />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="gambar_celana_1" autofocus />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <button id="submitButton" type="submit" class="btn btn-primary">
                            <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                            Input Laporan Press Kain
                        </button>
                        <a href="{{ route('getIndexDataMasukMesinAtexco') }}" class="btn btn-outline-secondary"><i
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