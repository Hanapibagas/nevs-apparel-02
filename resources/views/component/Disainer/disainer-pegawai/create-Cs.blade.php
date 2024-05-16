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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> <span class="text-muted fw-light"><a
                href="{{ route('getIndexDisainerPegawai') }}" style="color: inherit">Disainer</a></span>/ Kirim disain
        fix ke tim CS</h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Form untuk mengirim ke Costumer Services</h5>
                </div>
                <div class="card-body">
                    <form id="submissionForm" action="{{ route('postToCsPegawai', $disainer->nama_tim) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">nama tim</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name"
                                    value="{{ $disainer->nama_tim }}" readonly />
                                <input type="hidden" class="form-control" name="barang_masuk_disainer_id"
                                    id="basic-default-name" value="{{ $disainer->id }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">nama cs</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name"
                                    value="{{ $disainer->Users->name }}" readonly />
                                <input type="hidden" class="form-control" name="cs_id" id="basic-default-name"
                                    value="{{ $disainer->nama_cs }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Nama oprator
                                mesin</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name"
                                    value="{{ $disainer->DataMesinCs->first()->User->name ?? '' }}" readonly />
                                <input type="hidden" class="form-control" name="jenis_mesin" id="basic-default-name"
                                    value="{{ $disainer->DataMesinCs->first()->User->id ?? '' }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Upload Gambar</label>
                            <div class="col-sm-10">
                                <div id="imageUploads">
                                    <input type="file" class="form-control mb-2" name="file_baju_player"
                                        accept=".jpg, .png" />
                                </div>
                                <button type="button" class="btn btn-sm btn-success" onclick="addImageUpload()">Tambah
                                    Upload</button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">File Corel</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="basic-default-company"
                                    name="file_corel_disainer" accept=".cdr" required />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button id="submitButton" type="submit" class="btn btn-primary">
                                    <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                                    kirim
                                </button>
                                <a href="{{ route('getIndexDisainerPegawai') }}" class="btn btn-outline-secondary"><i
                                        class="menu-icon tf-icons bx bx-undo"></i>Kembali</a>
                            </div>
                        </div>
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
<script>
    var maxUploads = 8;
    var uploadCount = 0;

    function addImageUpload() {
        var container = document.getElementById('imageUploads');
        var inputs = container.querySelectorAll('input[type="file"]');
        if (inputs.length < maxUploads) {
            uploadCount++;
            var input = document.createElement('input');
            input.type = 'file';
            input.className = 'form-control mb-2';
            switch(uploadCount) {
                case 1:
                    input.name = 'file_celana_player';
                    break;
                case 2:
                    input.name = 'file_baju_kiper';
                    break;
                case 3:
                    input.name = 'file_celana_kiper';
                    break;
                case 4:
                    input.name = 'file_baju_pelatih';
                    break;
                case 5:
                    input.name = 'file_celana_pelatih';
                    break;
                case 6:
                    input.name = 'file_baju_1';
                    break;
                case 7:
                    input.name = 'file_celana_1';
                    break;
                default:
                    input.name = 'file_additional_' + (uploadCount - 6);
                    break;
            }
            input.accept = '.jpg, .png';
            container.appendChild(input);
        } else {
            alert('Maximum uploads limit reached!');
        }
    }
</script>



@endpush
