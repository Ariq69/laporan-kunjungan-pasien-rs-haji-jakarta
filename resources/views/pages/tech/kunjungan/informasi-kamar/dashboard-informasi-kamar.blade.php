@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row mb-3">
        <div class="col-lg-6 ">
        <h4>Informasi Kamar</h4>
        </div>
    </div>
    <div class="row row-cols-lg-4">
        <a href="{{ route('informasi-kamar-afiah') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">AFIAH</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_afiah }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-afiso') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">AFIAH ISOLASI</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_afiso }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-ama') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">AMANAH</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_ama }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-amab') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">AMANAH BAYI</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_amab }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-has1') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">HASANAH 1</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_has1 }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-has06') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">HASANAH 2 KELAS 1</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_has06 }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-has07') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">HASANAH 2 KELAS 2</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_has07 }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-has08') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">HASANAH 2 KELAS 3</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_has08 }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-syi') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">SYIFA</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_syi }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-syiso') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">SYIFA ISOLASI</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_syiso }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-sak') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">SAKINAH</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_sak }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-mul') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">MULTAZAM</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_mul }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-neo') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">NEONATUS</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_neo }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-icu') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">ICU</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_icu }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-iccu') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">ICCU</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_iccu }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('informasi-kamar-nicu') }}">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2">NICU</h5>
                                <h4 class="mb-2">{{ $jumlah_kamar_nicu }}</h4>
                                <div class="mb-0">
                                </div>
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
