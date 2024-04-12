@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> <span class="text-muted fw-light"><a
                href="{{ route('getIndexOrderCsPegawai') }}" style="color: inherit">Data Order</a></span>/ Buat data LK
    </h4>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Input </span>Data Order</h4>
                    <form id="submissionForm" action="{{ route('putDataLkPegawai', $oderCs->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label for="lastName" class="form-label">No. Nota</label>
                                                <input class="form-control" required type="text" name="no_nota"
                                                    id="lastName" placeholder="No. nota" />
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="firstName" class="form-label">No. Order</label>
                                                <input class="form-control" type="text" id="firstName" name="no_order"
                                                    value="{{ $oderCs->no_order }}" readonly autofocus />
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="lastName" class="form-label">Nama Tim</label>
                                                <input class="form-control" type="text" name="nama_tim" id="lastName"
                                                    value="{{ $oderCs->BarangMasukDisainer->nama_tim }}" readonly />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Admin</label>
                                                <input class="form-control" type="text" name="costumer_service"
                                                    id="lastName" value="{{ $oderCs->UsersOrder->name }}" readonly />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Deadline</label>
                                                <input class="form-control" required type="date" name="deadline"
                                                    id="lastName" value="" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label" for="country">Desainer</label>
                                                <input class="form-control" type="text" name="costumer_service"
                                                    id="lastName" value="{{ $oderCs->Users->name }}" readonly />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label" for="country">Layout</label>
                                                <select id="country" required name="layout_id"
                                                    class="select2 form-select">
                                                    <option value="">-- Pilih Pembagian Layout --</option>
                                                    @foreach ( $users as $user )
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->name }} sedang menangani LK {{
                                                        isset($userCounts[$user->id]) ? $userCounts[$user->id]
                                                        : 0}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Mesin Print</label>
                                                <input class="form-control" type="text" name="costumer_service"
                                                    id="lastName" value="{{ $oderCs->jenis_mesin }}" readonly />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="lastName" class="form-label">Kota</label>
                                                <select id="country" required name="kota_produksi"
                                                    class="select2 form-select">
                                                    <option value="">-- Kota Produksi --</option>
                                                    <option value="Makassar">Makassar</option>
                                                    <option value="Jakarta">Jakarta</option>
                                                    <option value="Surabaya">Surabaya</option>
                                                    <option value="Bandung">Bandung</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($oderCs->Gambar->file_baju_player)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#modalCenterPlayer"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select id="country" required name="pola_lengan_player_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kera_baju_player_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_sablon_baju_player" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_kain_baju_player" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_baju_player" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea name="ket_tambahan_baju_player" required
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_baju_pelayer"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterPlayer" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_baju_player) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($oderCs->Gambar->file_baju_pelatih)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#modalCenterPelatih"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select id="country" required name="pola_lengan_pelatih_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_baju_pelatih_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_sablon_baju_pelatih" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_kain_baju_pelatih" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_baju_pelatih" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_baju_pelatih"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_baju_pelatih"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterPelatih" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_baju_pelatih) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($oderCs->Gambar->file_baju_kiper)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#modalCenterKiper"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select id="country" required name="pola_lengan_kiper_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_baju_kiper_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_sablon_baju_kiper" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_kain_baju_kiper" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_baju_kiper" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_baju_kiper"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_baju_kiper"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterKiper" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_baju_kiper) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($oderCs->Gambar->file_baju_1)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal" data-bs-target="#modalCenter1"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select id="country" required name="pola_lengan_1_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_baju_1_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_sablon_baju_1" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_kain_baju_1" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_baju_1" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_baju_1"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_baju_1"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenter1" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_baju_1) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Celana --}}
                                        @if ($oderCs->Gambar->file_celana_player)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCenterCelanaPlayer"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select id="country" required name="pola_celana_player_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_celana_player_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_sablon_celana_player" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            name="jenis_kain_celana_player" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input class="form-control" required type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_celana_player" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_celana_player"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_celana_pelayer"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterCelanaPlayer" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_celana_player) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($oderCs->Gambar->file_celana_pelatih)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCenterCelanaPlayer"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select required id="country" name="pola_celana_pelatih_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_celana_pelatih_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            name="jenis_sablon_celana_pelatih"
                                                            placeholder="Jenis Sublim" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            name="jenis_kain_celana_pelatih" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_celana_pelatih"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_celana_pelatih"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_celana_pelatih"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterCelanaPlayer" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_celana_pelatih) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($oderCs->Gambar->file_celana_kiper)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCenterCelanaPlayer"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select required id="country" name="pola_celana_kiper_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_celana_kiper_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            name="jenis_sablon_celana_kiper" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            name="jenis_kain_celana_kiper" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_celana_kiper" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_celana_kiper"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_celana_kiper"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterCelanaPlayer" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_celana_kiper) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($oderCs->Gambar->file_celana_1)
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan Produksi
                                                    <i class="bx bx-show" style="cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCenterCelanaPlayer"></i>
                                                </h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Produksi</label>
                                                        <select required id="country" name="pola_celana_1_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Produksi --</option>
                                                            @foreach ( $lengan as $lengans )
                                                            <option value="{{ $lengans->id }}">{{ $lengans->jenis_kera
                                                                }} (Komisi {{ $lengans->status == 1 ? 'Aktif' :
                                                                'Tidak Aktif'}})
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan produksi)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">model</label>
                                                        <select id="country" required name="kerah_celana_1_id"
                                                            class="select2 form-select">
                                                            <option value="">-- Jenis Model --</option>
                                                            @foreach ( $kera as $keras )
                                                            <option value="{{ $keras->id }}">{{ $keras->jenis_kera }}
                                                            </option>
                                                            @endforeach
                                                            <option value="1">Opsional
                                                                (jika tidak ada pilhan model)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="country">Jenis Sublim</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            name="jenis_sablon_celana_1" placeholder="Jenis Sublim"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jenis Bahan</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            name="jenis_kain_celana_1" placeholder="Jenis Bahan"
                                                            autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Jumlah</label>
                                                        <input required class="form-control" type="text" id="firstName"
                                                            placeholder="Jumlah" name="total_celana_1" autofocus />
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label for="firstName" class="form-label">Ukuran</label>
                                                        <textarea required name="ket_tambahan_celana_1"
                                                            class="form-control"
                                                            placeholder="Contoh: M 10, L 2, Xl 1"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="country">Keterangan</label>
                                                        <textarea required class="form-control"
                                                            name="keterangan_celana_1"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="modalCenterCelanaPlayer" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Priview
                                                                    Gambar</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <img src="{{ asset('storage/'.$oderCs->gambar->file_celana_1) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="fw-bold py-3 mb-4">Keterangan
                                                    Tambahan</h4>
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <textarea class="form-control" rows="7"
                                                            name="keterangan_lengkap"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="submitButton" type="submit" class="btn btn-primary">
                            <i id="submitIcon" class="menu-icon tf-icons bx bx-send"></i>
                            Buat LK
                        </button>
                        <a href="{{ route('getIndexOrderCsPegawai') }}" class="btn btn-outline-secondary"><i
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
<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('keterangan_lengkap');
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