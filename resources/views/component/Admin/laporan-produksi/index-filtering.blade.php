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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> laporan jahit</h4>
        @if(!empty($dates) && !empty($totalsByCity))
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <canvas id="productionChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                    const ctx = document.getElementById('productionChart').getContext('2d');

                    const dates = @json($dates);
                    const totalsByCity = @json($totalsByCity);

                    const cities = ['Makassar', 'Bandung', 'Surabaya', 'Jakarta'];
                    const datasets = cities.map(city => {
                        const cityData = totalsByCity[city] ?? [];
                        const cityTotals = dates.map(date => {
                            const record = cityData.find(item => item.date === date);
                            return record ? record.total : 0;
                        });

                        return {
                            label: city,
                            data: cityTotals,
                            backgroundColor: getRandomColor(),
                        };
                    });

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: dates,
                            datasets: datasets
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Total Produksi'
                                    }
                                }
                            }
                        }
                    });

                    function getRandomColor() {
                        const letters = '0123456789ABCDEF';
                        let color = '#';
                        for (let i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                        return color;
                    }
                });
        </script>
        @endif
        <div class="card">
            <h5 class="card-header">Silahkan pilih tahun dan bulan untuk melihat jumlah jahit</h5>
            <form action="{{ route('getLaporanProduksi') }}" method="get">
                <div class="card-header row">
                    <div class="mb-3 col-md-3">
                        <label>Tahun</label>
                        @php
                        $year = date('Y');
                        @endphp
                        <select id="timeZones" class="select2 form-select" name="tahun" required>
                            <option value="">-- silahkan pilih tahun --</option>
                            @for ($i=2023; $i <= $year; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="">Bulan</label>
                        <select id="timeZones" class="select2 form-select" name="bulan" required>
                            <option value="">-- silahkan pilih bulan --</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const ctx = document.getElementById('productionChart').getContext('2d');

        const dates = @json($dates);
        const totalsByCity = @json($totalsByCity);

        const cities = ['Makassar', 'Bandung', 'Surabaya', 'Jakarta'];
        const datasets = cities.map(city => {
            const cityData = totalsByCity[city] ?? [];
            const cityTotals = dates.map(date => {
                const record = cityData.find(item => item.date === date);
                return record ? record.total : 0;
            });

            return {
                label: city,
                data: cityTotals,
                backgroundColor: getRandomColor(),
            };
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Produksi'
                        }
                    }
                }
            }
        });

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    });
</script>
<script>
    new DataTable('#cs');
</script>
@endpush