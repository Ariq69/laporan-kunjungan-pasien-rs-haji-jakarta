@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<style>
    /* Ukuran default di desktop */
.chart-container-lg-4 {
    width: 100%;
}

/* Aturan media query untuk mode ponsel */
@media (max-width: 767px) {
    .chart-container-lg-4 {
        width: 70%; /* Sesuaikan dengan ukuran yang Anda inginkan untuk mode ponsel */
    }
}
</style>
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
                                            Pasien Per Cara Bayar
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
                <!--Cara Bayar-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Jenis Bayar</h5>
                            <div class="chart-container-lg-4">
                            <canvas id="BarChartSumPayment"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Jumlah Pasien Per Poli-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                    <h5>Detail Pasien per Jenis Bayar</h5>
                    <div class="table-responsive">
                    <table class="table table-striped table-hover scroll-horizontal-vertical w-100">
                        <tr>
                            <th style="vertical-align: middle;" rowspan="2" class="text-center">Poliklinik</th>
                            <th colspan="4" class="text-center">Jumlah Pasien</th>
                            <th style="vertical-align: middle;" rowspan="2" class="text-center">Total</th>
                        </tr>
                        <tr>
                            <th class="text-center">BPJS</th>
                            <th class="text-center">Umum</th>
                            <th class="text-center">Perusahaan</th>
                            <th class="text-center">Admedika</th>
                        </tr>
                            @foreach ($details as $nm_poli => $poliDetails)
                                <tr>
                                    <td>{{ $nm_poli }}</td>
                                    <td class="text-center">{{ $poliDetails->firstWhere('kd_kel_pj', 'BPJ') ? $poliDetails->firstWhere('kd_kel_pj', 'BPJ')->jumlah_pasien : 0 }}</td>
                                    <td class="text-center">{{ $poliDetails->firstWhere('kd_kel_pj', 'UMUM') ? $poliDetails->firstWhere('kd_kel_pj', 'UMUM')->jumlah_pasien : 0 }}</td>
                                    <td class="text-center">{{ $poliDetails->firstWhere('kd_kel_pj', 'PER') ? $poliDetails->firstWhere('kd_kel_pj', 'PER')->jumlah_pasien : 0 }}</td>
                                    <td class="text-center">{{ $poliDetails->firstWhere('kd_kel_pj', 'ADM') ? $poliDetails->firstWhere('kd_kel_pj', 'ADM')->jumlah_pasien : 0 }}</td>
                                    <td class="text-center">
                                        {{ ($poliDetails->firstWhere('kd_kel_pj', 'BPJ') ? $poliDetails->firstWhere('kd_kel_pj', 'BPJ')->jumlah_pasien : 0) +
                                        ($poliDetails->firstWhere('kd_kel_pj', 'UMUM') ? $poliDetails->firstWhere('kd_kel_pj', 'UMUM')->jumlah_pasien : 0) +
                                        ($poliDetails->firstWhere('kd_kel_pj', 'PER') ? $poliDetails->firstWhere('kd_kel_pj', 'PER')->jumlah_pasien : 0) +
                                        ($poliDetails->firstWhere('kd_kel_pj', 'ADM') ? $poliDetails->firstWhere('kd_kel_pj', 'ADM')->jumlah_pasien : 0) }}
                                    </td>
                                </tr>
                            @endforeach
                    </table>
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
    var barQuery = @json($barQuery);
</script>

<script>
(function($) {
    $(document).ready(function() {
        var labels = Object.keys(barQuery);
        var data = Object.values(barQuery);
        //console.log(labels);
        var ctx = document.getElementById("BarChartSumPayment").getContext("2d");
        BarChartSumPayment.ChartData(ctx, 'bar', labels, data);
    });

    var BarChartSumPayment = {
        ChartData: function(ctx, type, labels, data) {
            new Chart(ctx, {
                type: type,
                data: {
                    labels: ['Admedika', 'BPJS', 'Perusahaan','Umum', 'Total'],
                    datasets: [
                        {
                            label: "Data Pasien",
                            data: data,
                            backgroundColor: ['#FF6384', '#36A2EB','#FFCE56','#bffc6f', '#6c3461'],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    labels: [{
                        render: 'value',
                        fontSize: '14',
                        position: 'outside',
                        arc:true
                    }],
                },
            }
            });
        },
    };
})(jQuery);
</script>
@endsection