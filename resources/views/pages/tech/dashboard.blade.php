@extends('layouts.dashboard')

@section('content')
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
        <div class="row">
            <div class="col-md-3 mt-1">
                <label for="From">Dari</label>
                <input type="date" id="from" name="from" class="form-control">
            </div>
            <div class="col-md-3 mt-1">
                <label for="To">Hingga</label>
                <input type="date" id="to" name="to" class="form-control">
            </div>
            <div class="col-md-3 mt-4">
                <input type="button" class="btn btn-success" value="Filter" onclick="getData()">
            </div>
        </div>
        <div class="col-lg-8 md-3 mt-3">
            <div class="chart-container" style="position: relative; height:50vh; width:80vw">
            <canvas id="canvas-1"></canvas>
            </div>
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

