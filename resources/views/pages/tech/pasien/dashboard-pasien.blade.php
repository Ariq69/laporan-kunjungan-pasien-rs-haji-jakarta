@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="row w-100">
        <div class="p-3 mt-4 mb-0">
            <h4>Data Pasien</h4>
        </div>
    </div>
    
    <div class="row row-cols-lg-4 mt-4">
        <!--Card Pasien-->
        <a href="{{ route('pasien-perpoli') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-poli</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-perdokter') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-dokter</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-perbulan') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Status</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
            
        <a href="{{ route('pasien-perjk') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Jenis Kelamin</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-carabayar') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Cara Bayar</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-perkabupaten') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Kabupaten</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-perkecamatan') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Kecamatan</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-peragama') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Agama</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-perumur') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Umur</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-persubang') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Suku Bangsa</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pasien-perbahasa') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Per-Bahasa</h5>
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
</main>
@endsection

