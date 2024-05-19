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
                    <form id="submissionForm" action="{{ route('putLaporanLs') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                @if (!empty($formattedData['player']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="playerId" name="player_id"
                                                value="{{ $formattedData['player'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_palayer" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number" name="poly_player"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layout" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['pelatih']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="pelatihId" name="pelatih_id"
                                                value="{{ $formattedData['pelatih'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_pelatih" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number" name="poly_pelatih"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layout2" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['kiper']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="kiperId" name="kiper_id"
                                                value="{{ $formattedData['kiper'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_kiper" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number" name="poly_kiper"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layou3" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['lk_1']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="lk1Id" name="lk1_id"
                                                value="{{ $formattedData['lk_1'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_1" id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number" name="poly_1"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layou4" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_player']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="celanaPlayerId" name="celana_player_id"
                                                value="{{ $formattedData['celana_player'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_celana_pelayer" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="poly_celana_pelayer" id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layou5" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_pelatih']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="celanaPelatihId" name="celana_pelatih_id"
                                                value="{{ $formattedData['celana_pelatih'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_celana_pelatih" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="poly_celana_pelatih" id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layou6" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan6"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_kiper']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="celanaKiperId" name="celana_kiper_id"
                                                value="{{ $formattedData['celana_kiper'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_celana_kiper" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="poly_celana_kiper" id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layou7" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan7"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if (!empty($formattedData['celana_1']))
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="celana1Id" name="celana_1_id"
                                                value="{{ $formattedData['celana_1'][0]['id'] }}">
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Kertas (Meter)</label>
                                                <input required class="form-control" type="number"
                                                    name="panjang_kertas_celana_1" id="lastName"
                                                    pattern="[0-9]+(\.[0-9]+)?" placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Nama kertas</label>
                                                <select id="country" required name="kertas_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Nama Kertas --</option>
                                                    @foreach ( $bahanKertas as $bahan )
                                                    <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Panjang Poly / DTF
                                                    (Meter)</label>
                                                <input required class="form-control" type="number" name="poly_celana_1"
                                                    id="lastName" pattern="[0-9]+(\.[0-9]+)?"
                                                    placeholder="Contoh: 10 meter" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">File Corel Layout</label>
                                                <input class="form-control" type="file" accept=".rar"
                                                    name="file_corel_layout8" id="lastName" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">keterangan tambahan</label>
                                                <textarea class="form-control" name="keterangan8"></textarea>
                                            </div>
                                        </div><br>
                                    </div>
                                </div>
                                @endif
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="row">
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-default-company">Upload Tangkap
                                                        Layar</label>
                                                    <div class="col-sm-10">
                                                        <div id="imageUploads">
                                                            <input type="file" class="form-control mb-2" required
                                                                name="file_tangkap_layar_player" accept=".jpg, .png" />
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addImageUpload()">Tambah
                                                            Upload</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                    </div>
                                </div>
                                <input type="hidden" id="localTime" name="local_time">
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
    document.getElementById('submissionForm').addEventListener('submit', function(event) {
    // Get the local time
    var now = new Date();
    var localTime = now.toLocaleString('en-GB', { hour12: false }); // e.g., "14/05/2024, 14:32:09"

    // Format the local time to match ISO 8601 without timezone information
    var localIsoTime = now.getFullYear() + '-' +
                       String(now.getMonth() + 1).padStart(2, '0') + '-' +
                       String(now.getDate()).padStart(2, '0') + 'T' +
                       String(now.getHours()).padStart(2, '0') + ':' +
                       String(now.getMinutes()).padStart(2, '0') + ':' +
                       String(now.getSeconds()).padStart(2, '0');

    // Set the value of the hidden input field
    document.getElementById('localTime').value = localIsoTime;
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
                    input.name = 'file_tangkap_layar_pelatih';
                    break;
                case 2:
                    input.name = 'file_tangkap_layar_kiper';
                    break;
                case 3:
                    input.name = 'file_tangkap_layar_1';
                    break;
                case 4:
                    input.name = 'file_tangkap_layar_celana_pelayer';
                    break;
                case 5:
                    input.name = 'file_tangkap_layar_celana_pelatih';
                    break;
                case 6:
                    input.name = 'file_tangkap_layar_celana_kiper';
                    break;
                case 7:
                    input.name = 'file_tangkap_layar_celana_1';
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
<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script>
    // CKEDITOR.replace('keterangan1');
    CKEDITOR.replace('keterangan_baju_pelayer');
    CKEDITOR.replace('keterangan_baju_pelatih');
    CKEDITOR.replace('keterangan_baju_kiper');
    CKEDITOR.replace('keterangan_baju_1');
    CKEDITOR.replace('keterangan_celana_pelayer');
    CKEDITOR.replace('keterangan_celana_pelatih');
    CKEDITOR.replace('keterangan_celana_kiper');
    CKEDITOR.replace('keterangan_celana_1');
</script>
@endpush
