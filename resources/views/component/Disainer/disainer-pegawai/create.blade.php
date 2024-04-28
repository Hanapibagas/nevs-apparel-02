@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> <span class="text-muted fw-light"><a
                href="{{ route('getIndexDisainerPegawai') }}" style="color: inherit">Disainer</a></span>/ Kirim data ke
        tim mesin</h4>

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Form untuk mengirim ke tim mesin</h5>
                </div>
                <div class="card-body">
                    <form id="submissionForm" action="{{ route('postToTeamMesinPegawai', $disainer->nama_tim) }}"
                        method="POST" enctype="multipart/form-data">
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
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Nama oprator
                                mesin</label>
                            <div class="col-sm-10">
                                <select id="country" required name="nama_mesin_id" class="select2 form-select">
                                    <option value="">-- Pilih Pembagian Mesin --</option>
                                    @foreach ( $mesin as $user )
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} sedang menangani LK {{
                                        isset($userCounts[$user->id]) ? $userCounts[$user->id]
                                        : 0}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" accept=".jpg, .eps" id="basic-default-company"
                                    name="file" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-message">keterangan</label>
                            <div class="col-sm-10">
                                <textarea id="basic-default-message" class="form-control"
                                    placeholder="Apakah anda ingin menyapaikan sesuatu ?" name="keterangan"
                                    aria-describedby="basic-icon-default-message2"></textarea>
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
@endpush
