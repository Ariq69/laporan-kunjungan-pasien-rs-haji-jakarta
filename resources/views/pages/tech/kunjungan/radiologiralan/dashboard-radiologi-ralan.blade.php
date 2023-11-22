@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
<div class="row">
            <section class="haji-breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('rawat-jalan') }}">Jenis Layanan</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Radiologi Ralan
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    <div class="row row-cols-lg-4 mt-4 justify-content-center">
    <!--Card Pasien-->
    <a href="{{ route('jenis_perawatan_radiologi_ralan') }}">
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Berdasarkan Permintaan </h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    
    <a href="{{ route('dokter_perujuk_ralan') }}">
        
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Berdasarkan Dokter Perujuk</h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('dokter_radiologi_ralan') }}">
    <!-- {{ route('jumlah_inventaris_barang_per_merk') }} -->
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Berdasarkan Dokter Periksa</h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    
</div>
</div>

</div>
</main>
@endsection

