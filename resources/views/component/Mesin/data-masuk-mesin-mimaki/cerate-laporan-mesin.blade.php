@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Input data laporan mesin mimaki
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Input </span>data laporan</h4>
                    <form id="submissionForm" action="{{ route('putLaporanMesin') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                @if (!empty($formattedData['player']))
                                <div class="card mb-4">
                                    <input type="hidden" id="playerId" name="player_id"
                                        value="{{ $formattedData['player'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto" type="file" id="firstName"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['pelatih']))
                                <div class="card mb-4">
                                    <input type="hidden" id="pelatihId" name="pelatih_id"
                                        value="{{ $formattedData['pelatih'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_pelatih" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['kiper']))
                                <div class="card mb-4">
                                    <input type="hidden" id="kiperId" name="kiper_id"
                                        value="{{ $formattedData['kiper'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_kiper" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['lk_1']))
                                <div class="card mb-4">
                                    <input type="hidden" id="lk1Id" name="lk1_id"
                                        value="{{ $formattedData['lk_1'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_1" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_player']))
                                <div class="card mb-4">
                                    <input type="hidden" id="celanaPlayerId" name="celana_player_id"
                                        value="{{ $formattedData['celana_player'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_celana_player" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_pelatih']))
                                <div class="card mb-4">
                                    <input type="hidden" id="celanaPelatihId" name="celana_pelatih_id"
                                        value="{{ $formattedData['celana_pelatih'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_celana_pelatih" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_kiper']))
                                <div class="card mb-4">
                                    <input type="hidden" id="celanaKiperId" name="celana_kiper_id"
                                        value="{{ $formattedData['celana_kiper'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_celana_kiper" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_1']))
                                <div class="card mb-4">
                                    <input type="hidden" id="celana1Id" name="celana_1_id"
                                        value="{{ $formattedData['celana_1'][0]['id'] }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">File foto</label>
                                                <input class="form-control" name="file_foto_celana_1" type="file"
                                                    id="firstName" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <button id="submitButton" type="submit" class="btn btn-primary">
                            <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                            Input Laporan Mesin Mimaki
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
    var playerId = document.getElementById('playerId').value;
    var pelatihId = document.getElementById('pelatihId').value;
    var kiperId = document.getElementById('kiperId').value;
    var lk1Id = document.getElementById('lk1Id').value;
    var celanaPlayerId = document.getElementById('celanaPlayerId').value;
    var celanaPelatihId = document.getElementById('celanaPelatihId').value;
    var celanaKiperId = document.getElementById('celanaKiperId').value;
    var celana1Id = document.getElementById('celana1Id').value;

    document.getElementById('hiddenPlayerId').value = pelatihId;
    document.getElementById('hiddenPelatihId').value = pelatihId;
    document.getElementById('hiddenKiperId').value = kiperId;
    document.getElementById('hiddenLk1Id').value = lk1Id;
    document.getElementById('hiddenCelanaPlayerId').value = celanaPlayerId;
    document.getElementById('hiddenCelanaKiperId').value = celanaKiperId;
    document.getElementById('hiddenCelana1Id').value = celana1Id;
</script>
<script>
    document.getElementById('submissionForm').addEventListener('submit', function () {
        document.getElementById('submitButton').setAttribute('disabled', 'true');
        var icon = document.getElementById('submitIcon');
        icon.classList.remove('bx-send');
        icon.classList.add('bx-loader');
    });
</script>
@endpush