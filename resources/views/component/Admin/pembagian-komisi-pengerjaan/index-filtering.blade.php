@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
@endpush

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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Komisi</h4>
        <div class="card">
            <h5 class="card-header">Silahkan pilih tahun, bulan dan kota untuk melihat pembagian komisi layout </h5>
            <form action="{{ route('getFilterPembagianKomisi') }}" method="GET">
                <div class="card-header row">
                    <div class="mb-3 col-md-3">
                        @php
                        $year = date('Y');
                        @endphp
                        <select id="timeZones" class="select2 form-select" name="tahun">
                            <option value="">-- silahkan pilih tahun --</option>
                            @for ($i=2023; $i <= $year; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <select id="timeZones" class="select2 form-select" name="bulan">
                            <option value="">-- silahkan pilih bulan --</option>
                            <option value="01">Januari</option>
                            <option value="02">Febuari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">september</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <select id="kotaProduksi" class="select2 form-select" name="kotaProduksi">
                            <option value="">-- silahkan pilih kota --</option>
                            <option value="Makassar">Makassar</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Surabaya">Surabaya</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" class="btn btn-primary form-control">Filter laporan komisi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    new DataTable('#cs');
</script>
@endpush