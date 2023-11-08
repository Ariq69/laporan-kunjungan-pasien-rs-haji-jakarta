@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="mb-3 mt-3">
        <div class="row">
            <section class="haji-breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('pasien') }}">Pasien</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Pasien Per Dokter
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <div class="container-fluid">
            <div class="row align-items-start">
                <!--Jumlah Pasien Per Poli-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Pasien Per Dokter</h5>
                            <form method="post" action="{{ url('/tech/pasien-perdokter') }}">
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
                                            <label for="poliklinik">Poliklinik</label>
                                            <select class="form-control" id="poliklinik" name="poliklinik">
                                                @foreach ($poliklinik as $poli)
                                                    <option value="{{ $poli->nm_poli }}">{{ $poli->nm_poli }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary mt-3">Tampilkan Grafik</button>
                                        </div>
                                    </div>
                                </form>
                            <div class="chart-container">
                                <canvas id="BarChartSumPasien" width="100px" height="45px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
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
    var poliSelect = document.getElementById('poliklinik');

    // Mengecek apakah ada nilai yang tersimpan di local storage
    var storedYear = localStorage.getItem('selectedYear');
    var storedMonth = localStorage.getItem('selectedMonth');
    var storedPoli = localStorage.getItem('selectedPoli');

    // Jika ada nilai yang tersimpan, set nilai-nilai filter sesuai dengan nilai yang tersimpan
    if (storedYear) {
        yearSelect.value = storedYear;
    }

    if (storedMonth) {
        monthSelect.value = storedMonth;
    }

    if (storedPoli) {
        poliSelect.value = storedPoli;
    }

    // Menyimpan nilai-nilai filter saat berubah
    yearSelect.addEventListener('change', function() {
        localStorage.setItem('selectedYear', yearSelect.value);
    });

    monthSelect.addEventListener('change', function() {
        localStorage.setItem('selectedMonth', monthSelect.value);
    });

    poliSelect.addEventListener('change', function() {
        localStorage.setItem('selectedPoli', poliSelect.value);
    });
</script>
<script>
    var queryDokter = @json($queryDokter);
</script>

<script>
(function($) {
    $(document).ready(function() {
        var labels = Object.keys(queryDokter);
        var data = Object.values(queryDokter);
        //console.log(labels);
        var ctx = document.getElementById("BarChartSumPasien").getContext("2d");
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
                            label: "Data Pasien",
                            data: data,
                            backgroundColor: [
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

