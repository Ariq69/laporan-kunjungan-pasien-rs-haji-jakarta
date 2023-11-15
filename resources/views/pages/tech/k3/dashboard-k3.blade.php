@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
            <div class="row align-items-start">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Kesehatan dan Keselamatan Kerja (K3)</h5>
                            <form method="post" action="{{ url('/tech/k3') }}">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                    <label for="year">Tahun</label>
                                    <select class="form-control" id="year" name="year">
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="month">Bulan</label>
                                    <select class="form-control" id="month" name="month">
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
                                        <!-- Tambahkan pilihan bulan lainnya -->
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mt-3">Tampilkan Grafik</button>
                                </div>
                                </div>
                            </form>
                            <div class="chart-container">
                                <canvas id="BarChartSumIGD" width="130px" height="45px"></canvas>
                            </div>
                            <div class="container-fluid">
                            <div class="card-body">
                            <div class="container-fluid">
                        </div> 
                        </div>
                        </div>
                        <div class="row row-cols-lg-4 mt-4">
                            <!--Card Pasien-->
                            <a href="{{ route('k3-bagian-tubuh') }}">
                                <div class="col-12 d-flex">
                                    <div class="card flex-fill border-0 kotak">
                                        <div class="card-body py-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grown-1">
                                                    <h5 class="mb-2">Bagian Tubuh</h5>
                                                    <h4 class="mb-2"></h4>
                                                    <div class="mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('k3-dampak-cidera') }}">
                                <div class="col-12 d-flex">
                                    <div class="card flex-fill border-0 kotak">
                                        <div class="card-body py-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grown-1">
                                                    <h5 class="mb-2">Dampak Cidera</h5>
                                                    <h4 class="mb-2"></h4>
                                                    <div class="mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('k3-jenis-cidera') }}">
                                <div class="col-12 d-flex">
                                    <div class="card flex-fill border-0 kotak">
                                        <div class="card-body py-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grown-1">
                                                    <h5 class="mb-2">Jenis Cidera</h5>
                                                    <h4 class="mb-2"></h4>
                                                    <div class="mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                                
                            <a href="{{ route('k3-jenis-luka') }}">
                                <div class="col-12 d-flex">
                                    <div class="card flex-fill border-0 kotak">
                                        <div class="card-body py-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grown-1">
                                                    <h5 class="mb-2">Jenis Luka</h5>
                                                    <h4 class="mb-2"></h4>
                                                    <div class="mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('k3-jenis-pekerjaan') }}">
                                <div class="col-12 d-flex">
                                    <div class="card flex-fill border-0 kotak">
                                        <div class="card-body py-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grown-1">
                                                    <h5 class="mb-2">Jenis Pekerjaan</h5>
                                                    <h4 class="mb-2"></h4>
                                                    <div class="mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('k3-lokasi-kejadian') }}">
                                <div class="col-12 d-flex">
                                    <div class="card flex-fill border-0 kotak">
                                        <div class="card-body py-4">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grown-1">
                                                    <h5 class="mb-2">Lokasi Kejadian</h5>
                                                    <h4 class="mb-2"></h4>
                                                    <div class="mb-0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        <a href="{{ route('k3-penyebab-kecelakaan') }}">
                            <div class="col-12 d-flex">
                                <div class="card flex-fill border-0 kotak">
                                    <div class="card-body py-4">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grown-1">
                                                <h5 class="mb-2">Penyebab</h5>
                                                <h4 class="mb-2"></h4>
                                                <div class="mb-0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

<script>
    // Simpan nilai-nilai filter saat halaman dimuat
    var yearSelect = document.getElementById('year');
    var monthSelect = document.getElementById('month');

    // Mengecek apakah ada nilai yang tersimpan di local storage
    var storedYear = localStorage.getItem('selectedYear');
    var storedMonth = localStorage.getItem('selectedMonth');

    // Jika ada nilai yang tersimpan, set nilai-nilai filter sesuai dengan nilai yang tersimpan
    if (storedYear) {
        yearSelect.value = storedYear;
    }

    if (storedMonth) {
        monthSelect.value = storedMonth;
    }

    // Menyimpan nilai-nilai filter saat berubah
    yearSelect.addEventListener('change', function() {
        localStorage.setItem('selectedYear', yearSelect.value);
    });

    monthSelect.addEventListener('change', function() {
        localStorage.setItem('selectedMonth', monthSelect.value);
    });
</script>
<script>
    var query = @json($query);
</script>

<script>
(function($) {
    $(document).ready(function() {
        var labels = Object.keys(query);
        var data = Object.values(query);
        //console.log(labels);
        var ctx = document.getElementById("BarChartSumIGD").getContext("2d");
        BarChartSumPasien.ChartData(ctx, 'bar', labels, data);
    });

    var BarChartSumPasien = {
        ChartData: function(ctx, type, labels, data) {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Data K3",
                            data: data,
                            backgroundColor: [
                                '#554994',
                                '#6E85B7',
                                '#C9BBCF',
                                '#73A9AD',
                                '#525E75',
                                '#655D8A',
                                '#BB6464',
                                '#A267AC',
                                '#867070',
                                '#6096B4',
                                '#DEBACE',
                                '#B3A492',
                                '#219C90',
                                '#9EB384',
                                '#FFC95F',
                                '#0E21A0',
                                '#9D44C0',
                                '#FF8080',
                                '#F9B572',
                                '#F6FDC3',
                                '#C8E4B2',
                                '#FFD966',
                                '#94AF9F',
                                '#C8FFD4',
                                '#B8E8FC',
                                '#B1AFFF',
                                '#7895B2',
                                '#FF7676',
                                '#3085C3',
                                '#5CD2E6',
                                '#5C4B99',
                                '#D71313',
                                '#45CFDD',
                                '#22A699',
                                '#245953',
                                '#913175',
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        labels: {
                            render: 'value',
                        },
                    },
                },
            });
        },
    };
})(jQuery);
</script>
@endsection

