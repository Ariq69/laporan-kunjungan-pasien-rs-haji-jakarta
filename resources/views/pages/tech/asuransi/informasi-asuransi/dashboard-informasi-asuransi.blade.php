@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row mb-3">
        <div class="col-lg-6 ">
        <h4>Informasi Asuransi</h4>
        </div>
    </div>
    <div class="row row-cols-lg-4">
        <a href="{{ route('informasi-asuransi-admed') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">ADMEDIKA</h5>
                                <h4 class="mb-2">{{ $jumlah_asuransi_admed }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="#">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">BPJS</h5>
                                <h4 class="mb-2">453</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="#">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">BPJS</h5>
                                <h4 class="mb-2">453</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="#">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">BPJS</h5>
                                <h4 class="mb-2">453</h4>
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
</main>
@endsection
