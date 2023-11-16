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
                                            <a href="{{ route('jumlah_inventaris') }}">Jumlah Inventaris</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Jumlah Inventaris Barang Per-Kategori
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
                            <h5 class="card-title">Jumlah Inventaris Barang Per-Kategori</h5>
                            <form method="post" action="{{ url('/tech/jumlah_inventaris_barang_per_kategori') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inventaris_barang">Barang</label>
                                            <select class="form-control" id="inventaris_barang" name="inventaris_barang">
                                                @foreach ($inventaris_barang as $ib)
                                                    <option value="{{ $ib->nama_barang }}">{{ $ib->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inventaris_kategori">Kategori</label>
                                            <select class="form-control" id="inventaris_kategori" name="inventaris_kategori">
                                                @foreach ($inventaris_kategori as $ik)
                                                    <option value="{{ $ik->nama_kategori }}">{{ $ik->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <label for="inventaris_produsen">Produsen</label>
                                            <select class="form-control" id="inventaris_produsen" name="inventaris_produsen">
                                                @foreach ($inventaris_produsen as $ip)
                                                    <option value="{{ $ip->nama_produsen }}">{{ $ip->nama_produsen }}</option>
                                                @endforeach
                                            </select>
                                        </div> -->
                                        <!-- 
                                        <div class="col-md-6">
                                            <label for="inventaris_merk">Merk</label>
                                            <select class="form-control" id="inventaris_merk" name="inventaris_merk">
                                                @foreach ($inventaris_merk as $im)
                                                    <option value="{{ $im->nama_merk }}">{{ $im->nama_merk }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inventaris_kategori">Kategori</label>
                                            <select class="form-control" id="inventaris_kategori" name="inventaris_kategori">
                                                @foreach ($inventaris_kategori as $ik)
                                                    <option value="{{ $ik->nama_kategori }}">{{ $ik->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inventaris_jenis">Jenis</label>
                                            <select class="form-control" id="inventaris_jenis" name="inventaris_jenis">
                                                @foreach ($inventaris_jenis as $ij)
                                                    <option value="{{ $ij->nama_jenis }}">{{ $ij->nama_jenis }}</option>
                                                @endforeach
                                            </select>
                                        </div> -->
                                    </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary mt-3">Tampilkan Grafik</button>
                                        </div>
                                    </div>
                                </form>
                            <div class="chart-container">
                                <canvas id="BarChartSumInventarisRuang" width="100px" height="45px"></canvas>
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
    // Simpan nilai-nilai filter saat halaman dimuats
    var ibSelect = document.getElementById('inventaris_barang');
    // var ipSelect = document.getElementById('inventaris_produsen');
    // var imSelect = document.getElementById('inventaris_merk');
    var ikSelect = document.getElementById('inventaris_kategori');
    // var ijSelect = document.getElementById('inventaris_jenis');


    // Mengecek apakah ada nilai yang tersimpan di local storage
    
    var storedib = localStorage.getItem('selectedib');
    // var storedip = localStorage.getItem('selectedip');
    // var storedim = localStorage.getItem('selectedim');
    var storedik = localStorage.getItem('selectedik');
    // var storedij = localStorage.getItem('selectedij');

    // Jika ada nilai yang tersimpan, set nilai-nilai filter sesuai dengan nilai yang tersimpan
   

    if (storedib) {
        ibSelect.value = storedib;
    }

    // if (storedip) {
    //     ipSelect.value = storedip;
    // }


    // if (storedim) {
    //     imSelect.value = storedim;
    // }

    if (storedik) {
        ikSelect.value = storedik;
    }

    
    // if (storedij) {
    //     ijSelect.value = storedij;
    // }

    
    // Menyimpan nilai-nilai filter saat berubah
   

    ibSelect.addEventListener('change', function() {
        localStorage.setItem('selectedib', ibSelect.value);
    });

    // ipSelect.addEventListener('change', function() {
    //     localStorage.setItem('selectedip', ipSelect.value);
    // });

    // imSelect.addEventListener('change', function() {
    //     localStorage.setItem('selectedim', imSelect.value);
    // });

    ikSelect.addEventListener('change', function() {
        localStorage.setItem('selectedik', ikSelect.value);
    });

    // ijSelect.addEventListener('change', function() {
    //     localStorage.setItem('selectedij', ijSelect.value);
    // });

    

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
        var ctx = document.getElementById("BarChartSumInventarisRuang").getContext("2d");
        BarChartSumInventarisRuang.ChartData(ctx, 'bar', labels, data);
    });

    var BarChartSumInventarisRuang = {
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

