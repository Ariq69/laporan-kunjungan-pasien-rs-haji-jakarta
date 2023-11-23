@extends('layouts.dashboard')

@section('content')
    <!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="row w-100">
        <div class="p-3 mt-4 mb-0">
            <h4>Jenis Penunjang IGD</h4>
        </div>
    </div>
    
    <div class="row row-cols-lg-4 mt-4">
        <!--Card Pasien-->
        <a href="{{ route('igd-lab') }}">
            <div class="col-12 d-flex kotak-overlay">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Laboratorium</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('ranap-rad') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Radiologi</h5>
                                <h4 class="mb-2"></h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('igd-hemo') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0 kotak">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">Hemodialisa</h5>
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

@section('js')
    
@endsection