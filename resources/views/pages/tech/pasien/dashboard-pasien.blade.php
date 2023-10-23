@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="mb-3 mt-3">
        <div class="row">
            <div class="col-lg-6 ">
            <h4>Data Pasien</h4>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row align-items-start">
                <!--Jumlah Pasien Per Poli-->
                <div class="col">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">Jumlah Pasien Per Poli</h5>
                        <div class="chart-container">
                            <form method="post" action="{{ url('/tech/pasien') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="year">Tahun</label>
                                    <select class="form-control" id="year" name="year">
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
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
                                <button type="submit" class="btn btn-primary mt-3">Tampilkan Grafik</button>
                            </form>
                            <canvas id="BarChartSumPasien" width="100px" height="45px"></canvas>
                        </div>
                    </div>
                </div>
                </div>

                <!--Cara Bayar-->
                <div class="col">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">Jenis Bayar</h5>
                        <div class="chart-container">
                        <canvas id="PieChartSumPayment" width="100px" height="45px"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>


<script>
    var query = @json($query);
    var pieQuery = @json($pieQuery);
</script>

<script>
(function($) {
    $(document).ready(function() {
        var labels = Object.keys(pieQuery);
        var data = Object.values(pieQuery);
        //console.log(labels);
        var ctx = document.getElementById("PieChartSumPayment").getContext("2d");
        PieChartSumPayment.ChartData(ctx, 'pie', labels, data);
    });

    var PieChartSumPayment = {
        ChartData: function(ctx, type, labels, data) {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: ['Admedika', 'BPJS', 'Perusahaan','Umum'],
                    datasets: [
                        {
                            label: "Data Pasien",
                            data: data,
                            backgroundColor: ['#FF6384', '#36A2EB','#FFCE56','#bffc6f'],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                labels: [{
                    render: 'label',
                    position: 'outside',
                    arc:true
                },
                {
                    render:'percentage',
                    fontColor: 'white',
                    position:'bottom',
                    fontSize: 15,
                },
                ],
                },
            }
            });
        },
    };
})(jQuery);
</script>
<script>
(function($) {
    $(document).ready(function() {
        var labels = Object.keys(query);
        var data = Object.values(query);
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
                            backgroundColor: '#96bfff',
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                    labels: {
                        render: 'value',
                    }
                    },
                },
            });
        },
    };
})(jQuery);
</script>
@endsection

