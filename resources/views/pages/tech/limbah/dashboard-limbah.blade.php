@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
            <div class="row align-items-start">
                <section class="haji-breadcrumbs">
                    </section>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Olah Limbah</h5>
                            <form method="post" action="{{ url('/tech/limbah') }}">
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
                                    <label for="tipe_limbah">Jenis Limbah</label>
                                    <select class="form-control" id="tipe_limbah" name="tipe_limbah">
                                        <option name="B3" value="B3">Limbah B3 Medis</option>
                                        <option name="B3Cair" value="B3Cair">Limbah B3 Medis Cair</option>
                                        <option name="Domestik" value="Domestik">Limbah Padat Domestik</option>
                                        <!-- Add more lab options as needed -->
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mt-3">Tampilkan Grafik</button>
                                </div>
                                </div>
                            </form>
                            <div class="chart-container">
                                <canvas id="BarChartSumLab" width="100px" height="45px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <h4>Data Mutu Air Limbah</h4>
                        <table class="table table-striped" id="dataMutuAirLimbah">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Meteran</th>
                                    <th>Jumlah Harian</th>
                                    <th>PH</th>
                                    <th>Suhu</th>
                                    <th>TDS</th>
                                    <th>EC</th>
                                    <th>Salt</th>
                                </tr>
                            </thead>
                        </table>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

<script>
    // Simpan nilai-nilai filter saat halaman dimuat
    var yearSelect = document.getElementById('year');
    var monthSelect = document.getElementById('month');
    var tipelimbahSelect = document.getElementById('tipe_limbah');

    // Mengecek apakah ada nilai yang tersimpan di local storage
    var storedYear = localStorage.getItem('selectedYear');
    var storedMonth = localStorage.getItem('selectedMonth');
    var storedtipelimbah = localStorage.getItem('selectedtipelimbah');

    // Jika ada nilai yang tersimpan, set nilai-nilai filter sesuai dengan nilai yang tersimpan
    if (storedYear) {
        yearSelect.value = storedYear;
    }

    if (storedMonth) {
        monthSelect.value = storedMonth;
    }

    if (storedtipelimbah) {
        tipelimbahSelect.value = storedtipelimbah;
    }

    // Menyimpan nilai-nilai filter saat berubah
    yearSelect.addEventListener('change', function() {
        localStorage.setItem('selectedYear', yearSelect.value);
    });

    monthSelect.addEventListener('change', function() {
        localStorage.setItem('selectedMonth', monthSelect.value);
    });

    tipelimbahSelect.addEventListener('change', function() {
        localStorage.setItem('selectedtipelimbah', tipelimbahSelect.value);
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
        var ctx = document.getElementById("BarChartSumLab").getContext("2d");
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
                            label: "Data Laboratorium",
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
<script>
    $(document).ready(function() {
        $('#dataMutuAirLimbah').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
            url: '{!! url()->current() !!}',
            },
            columns: [
                { data: 'tanggal', name: 'tanggal' },
                { data: 'meteran', name: 'meteran' },
                { data: 'jumlahharian', name: 'jumlahharian' },
                { data: 'ph', name: 'ph' },
                { data: 'suhu', name: 'suhu' },
                { data: 'tds', name: 'tds' },
                { data: 'ec', name: 'ec' },
                { data: 'salt', name: 'salt' },
            ],
        });
    });
</script>
@endsection