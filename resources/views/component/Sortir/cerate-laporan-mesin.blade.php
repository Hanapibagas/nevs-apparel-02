@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Input data laporan Sortir
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Input </span>data laporan</h4>
                    <form id="submissionForm" action="{{ route('putLaporanSortir') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @if (!empty($formattedData['player']))
                            <input type="hidden" id="playerId" name="player_id"
                                value="{{ $formattedData['player'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error" autofocus required placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas" autofocus required placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat" autofocus required placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan" autofocus required placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['pelatih']))
                            <input type="hidden" id="pelatihId" name="pelatih_id"
                                value="{{ $formattedData['pelatih'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_pelatih" autofocus required
                                                    placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_pelatih" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_pelatih" autofocus required placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_pelatih" autofocus required
                                                    placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_pelatih" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['kiper']))
                            <input type="hidden" id="kiperId" name="kiper_id"
                                value="{{ $formattedData['kiper'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_kiper" autofocus required
                                                    placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_kiper" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_kiper" autofocus required placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_kiper" autofocus required
                                                    placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_kiper" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['lk_1']))
                            <input type="hidden" id="lk1Id" name="lk1_id" value="{{ $formattedData['lk_1'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_1" autofocus required placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_1" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_1" autofocus required placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_1" autofocus required placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_1" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['celana_player']))
                            <input type="hidden" id="celanaPlayerId" name="celana_player_id"
                                value="{{ $formattedData['celana_player'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_celana_pelayer" autofocus required
                                                    placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_celana_pelayer" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_celana_pelayer" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_celana_pelayer" autofocus required
                                                    placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_celana_pelayer" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['celana_pelatih']))
                            <input type="hidden" id="celanaPelatihId" name="celana_pelatih_id"
                                value="{{ $formattedData['celana_pelatih'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_celana_pelatih" autofocus required
                                                    placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_celana_pelatih" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_celana_pelatih" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_celana_pelatih" autofocus required
                                                    placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_celana_pelatih" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['celana_kiper']))
                            <input type="hidden" id="celanaKiperId" name="celana_kiper_id"
                                value="{{ $formattedData['celana_kiper'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_celana_kiper" autofocus required
                                                    placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_celana_kiper" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_celana_kiper" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_celana_kiper" autofocus required
                                                    placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_celana_kiper" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($formattedData['celana_1']))
                            <input type="hidden" id="celana1Id" name="celana_1_id"
                                value="{{ $formattedData['celana_1'][0]['id'] }}">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">No. Error</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="no_error_celana_1" autofocus required
                                                    placeholder="Contoh:123456" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Panjang Kertas (M)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="panjang_kertas_celana_1" autofocus required
                                                    placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">Berat Kain (Kg)</label>
                                                <input required class="form-control" type="number" id="firstName"
                                                    name="berat_celana_1" autofocus required placeholder="Contoh: 1" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">nama bahan</label>
                                                <input required class="form-control" type="text" id="firstName"
                                                    name="bahan_celana_1" autofocus required
                                                    placeholder="Contoh: Bahan A" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="firstName" class="form-label">file foto</label>
                                                <input required class="form-control" type="file" id="firstName"
                                                    name="foto_celana_1" autofocus required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button id="submitButton" type="submit" class="btn btn-primary">
                            <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                            Input Laporan Sortir
                        </button>
                        <a href="{{ route('getIndexSortir') }}" class="btn btn-outline-secondary"><i
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
