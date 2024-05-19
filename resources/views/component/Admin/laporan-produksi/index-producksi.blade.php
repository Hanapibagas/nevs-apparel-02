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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> laporan Semua Produksi</h4>

        <div class="card">
            <h5 class="card-header">laporan Bahan kain</h5>
            <form action="{{ route('getLaporanbahankain') }}" method="get" target="_blank">
                <div class="card-header row">
                    <div class="mb-3 col-md-3">
                        <label>Dari</label>
                        <input type="date" class="form-select" name="dari">
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label>Ke</label>
                        <input type="date" class="form-select" name="ke">
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" style="margin-top: 20px"
                            class="btn btn-primary form-control">Kirim</button>
                    </div>
                </div>
            </form>
        </div> <br>
        <div class="card">
            <h5 class="card-header">laporan Bahan Kertas</h5>
            <form action="{{ route('getLaporanKertas') }}" method="get" target="_blank">
                <div class="card-header row">
                    <div class="mb-3 col-md-3">
                        <label>Dari</label>
                        <input type="date" class="form-select" name="dari">
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label>Ke</label>
                        <input type="date" class="form-select" name="ke">
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" style="margin-top: 20px"
                            class="btn btn-primary form-control">Kirim</button>
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
