@extends('layouts.dashboard')

@section('content')

<style>

.divider {
    width: 100%;
    height: 1px;
    background-color: #BBB;
    margin: 1rem 0;

}

</style>

<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3">
        <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="flex-fill border-0 illustration">
            <div class="card-body p-1 d-flex flex-fill">
                <div class="row g-0 w-100">
                <div class="p-3 m-2">
                    <h4>Welcome back, {{ Auth::user()->name }}!</h4>
                    <p class="mb-0">Apa yang akan kamu lakukan?</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="row mx-3">
        <!--Bar Chart-->
        <div class="card">
            <div class="card-body">
                <h4>Data Kunjungan Pasien</h4>
                <form method="post" action="{{ url('/tech/dashboard')}}" id="filter-form">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="year">Tahun</label>
                            <select class="form-control" id="year" name="year">
                                @foreach ( $years as $year )
                                    <option value="{{ $year->year }}">{{$year->year}}</option>
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
                            </select>
                        </div>
                        <div class="col">
                        <button type="submit" class="btn btn-primary mt-4" id="submit">Tampilkan Grafik</button>
                        </div>
                    </div>
                </form>
                <div class="divider"></div>
            </div>
            <canvas id="BarKunjungan" width="100px" height="45px"></canvas>
        </div>
        <!--Pie Chart-->
        <div class="col-lg-4 md-3">
            <div class="chart-container" style="position: relative; height:45vh; width:80vw">
            <canvas id="canvas-2"></canvas>
            </div>
        </div>
        </div>

        <!--Section Card-->
        <div class="container-fluid">
        <div class="row w-100">
            <div class="p-3 mt-4 mb-0">
                <h4>Data Pengguna</h4>
            </div>
        </div>
            <div class="row row-cols-lg-4 mt-4">
            <!--Card Pasien-->
            <a href="{{ route('pasien') }}">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Pasien</h5>
                        <h4 class="mb-2">{{ $jumlah_pasien }}</h4>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
            <!--Card Dokter-->
            <a href="{{ route('data-dokter') }}">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Dokter</h5>
                        <h4 class="mb-2">{{ $jumlah_dokter }}</h4>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
            <!--Card Perawat-->
            <a href="{{ route('data-perawat') }}">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Perawat</h5>
                        <h4 class="mb-2">{{ $jumlah_perawat }}</h4>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
            <!--Card Pegawai-->
            <a href="{{ route('data-pegawai') }}">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Pegawai</h5>
                        <h4 class="mb-2">{{ $jumlah_pegawai }}</h4>
                        <div class="mb-0">
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
        </div>

        <div class="row row-cols-lg-4 mt-4">
            <div class="row w-100">
            <div class="p-3 mt-0">
                <h4>Data Pelayanan</h4>
            </div>
            </div>
            <!--Card Poliklinik-->
            <a href="{{ route('informasi-kamar') }}">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Informasi Kamar</h5>
                        <h4 class="mb-2">{{ $jumlah_kamar }}</h4>
                        <div class="mb-0">
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
            <!--Card Rawat Jalan-->
            <a href="{{ route('informasi-asuransi') }}">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Asuransi</h5>
                        <h4 class="mb-2">{{ $jumlah_asuransi }}</h4>
                        <div class="mb-0">
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
            <!--Card Rawat Inap-->
            <a href="">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Poliklinik</h5>
                        <h4 class="mb-2">{{ $jumlah_poli }}</h4>
                        <div class="mb-0">
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </a>
            <!--Card Kunjungan-->
            <a href="">
                <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                    <div class="flex-grown-1">
                        <h5 class="mb-2">Jumlah Rawat Jalan</h5>
                        <h4 class="mb-2">2.987</h4>
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

@push('addon-script')
    <script>
        var yearSelect = document.getElementById('year');
        var monthSelect = document.getElementById('month');
        var applyFilterButton = document.getElementById('submit')

        var storedYear = localStorage.getItem('selectedYear');
        var storedMonth = localStorage.getItem('selectedMonth');

        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth() + 1;

        if (storedYear) {
            yearSelect.value = storedYear;
        } else {
            yearSelect.value = currentDate;
        }

        if (storedMonth) {
            monthSelect.value = storedMonth;
        } else {
            monthSelect.value = currentMonth;
        }

        yearSelect.addEventListener('change', function() {
            localStorage.setItem('selectedYear', yearSelect.value);
        });

        monthSelect.addEventListener('change', function() {
            localStorage.setItem('selectedMonth', monthSelect.value);
        });

        applyFilterButton.addEventListener('click', function() {
            // 
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    <script>
        var query = @json($query);
    </script>

    <script>
        (function($) {
            $(document).ready(function() {
                var labels = Object.keys(query);
                var data = Object.values(query);
                var bulan = [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember',
                ];

                var ctx = document.getElementById("BarKunjungan").getContext("2d");
                BarKunjungan.ChartData(ctx, 'bar', labels, data, bulan);
            });

            var BarKunjungan = {
                ChartData: function(ctx, type, labels, data, bulan) {
                    new Chart(ctx, {
                        type: type,
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: "Data Kunjungan Pasien",
                                    data: data,
                                    backgroundColor: '#96bfff',
                                    borderWidth: 1,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            maintainFontRation: true,
                            plugins: {
                                labels: {
                                    render:'value',
                                },
                            },
                        },
                    });
                },
            };
        })(jQuery);
    </script>
@endpush
