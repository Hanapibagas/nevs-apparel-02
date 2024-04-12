@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (Auth::user()->roles == 'super_admin')
    <div class="container">
        <canvas id="barChart" width="800" height="400"></canvas>
    </div>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <h5 class="card-header">Silahkan pilih tahun, bulan dan tanggal untuk melihat jumlah jahit </h5>
                <form action="{{ route('indexHome') }}" method="get">
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
                            <label for="">Tanggal</label>
                            <input required class="form-control" type="number" name="tanggal" />
                        </div>
                        <div class="mb-3 col-md-3">
                            <button type="submit" class="btn btn-primary form-control">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="mb-2">{{ $total_semua }}</h2>
                                    <span>Total Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (Auth::user()->roles == 'cs')
    <div class="container">
        <canvas id="myBarChart"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'disainer')
    <div class="container">
        <canvas id="myBarChart1"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'layout')
    <div class="container">
        <canvas id="myBarChart2"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'atexco')
    <div class="container">
        <canvas id="myBarChart3"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'mimaki')
    <div class="container">
        <canvas id="myBarChart4"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'pres_kain')
    <div class="container">
        <canvas id="myBarChart5"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'cut')
    <div class="container">
        <canvas id="myBarChart6"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'sortir')
    <div class="container">
        <canvas id="myBarChart7"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'jahit')
    <div class="container">
        <canvas id="myBarChart8"></canvas>
    </div>
    @endif
    @if (Auth::user()->roles == 'finis')
    <div class="container">
        <canvas id="myBarChart9"></canvas>
    </div>
    @endif
</div>
@endsection

@push('js')
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("form").addEventListener("submit", function(event) {
            event.preventDefault(); // Menghentikan perilaku default dari formulir (reload halaman)

            // Ambil nilai tahun, bulan, dan tanggal dari formulir
            var tahun = document.querySelector("select[name='tahun']").value;
            var bulan = document.querySelector("select[name='bulan']").value;
            var tanggal = document.querySelector("input[name='tanggal']").value;

            // Lakukan pengiriman data formulir dengan AJAX atau perintah lainnya di sini
            console.log("Tahun: " + tahun + ", Bulan: " + bulan + ", Tanggal: " + tanggal);

            // Contoh penggunaan AJAX dengan jQuery
            $.ajax({
                url: "{{ route('indexHome') }}",
                method: "GET",
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    tanggal: tanggal
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var dashboardMakassar = {!! $dashboardMakassar !!};
    var dashboardBandung = {!! $dashboardBandung !!};
    var dashboardSurabaya = {!! $dashboardSurabaya !!};
    var dashboardJakarta = {!! $dashboardJakarta !!};

    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    var data = {
        labels: months,
        datasets: [
            {
                label: 'Makassar',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: months.map((month, index) => {
                    var dashboardData = dashboardMakassar.find(data => data.month === index + 1);
                    return dashboardData ? dashboardData.total : 0;
                })
            },
            {
                label: 'Bandung',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: months.map((month, index) => {
                    var dashboardData = dashboardBandung.find(data => data.month === index + 1);
                    return dashboardData ? dashboardData.total : 0;
                })
            },
            {
                label: 'Surabaya',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                data: months.map((month, index) => {
                    var dashboardData = dashboardSurabaya.find(data => data.month === index + 1);
                    return dashboardData ? dashboardData.total : 0;
                })
            },
            {
                label: 'Jakarta',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: months.map((month, index) => {
                    var dashboardData = dashboardJakarta.find(data => data.month === index + 1);
                    return dashboardData ? dashboardData.total : 0;
                })
            }
        ]
    };

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };

    var ctx = document.getElementById('barChart').getContext('2d');

    var barChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
</script>


<script>
    var dataFromServer = <?php echo json_encode($dataMasuk); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukDisainer); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart1').getContext('2d');
    var myBarChart1 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasuklayout); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart2').getContext('2d');
    var myBarChart2 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukAtexco); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart3').getContext('2d');
    var myBarChart3 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukPressKain); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart5').getContext('2d');
    var myBarChart5 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukCut); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart6').getContext('2d');
    var myBarChart6 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukSortir); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart7').getContext('2d');
    var myBarChart7 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukjahit); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart8').getContext('2d');
    var myBarChart8 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukFinis); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart9').getContext('2d');
    var myBarChart9 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    var dataFromServer = <?php echo json_encode($dataMasukMimaki); ?>;
    dataFromServer.sort(function(a, b) {
        return a.month - b.month;
    });
    var labels = dataFromServer.map(function(item) {
        var monthNames = [
            "January", "February", "March",
            "April", "May", "June", "July",
            "August", "September", "October",
            "November", "December"
        ];
        return monthNames[item.month - 1];
    });

    var data = dataFromServer.map(function(item) {
        return item.total;
    });

    var ctx = document.getElementById('myBarChart4').getContext('2d');
    var myBarChart4 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Data Masuk',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush