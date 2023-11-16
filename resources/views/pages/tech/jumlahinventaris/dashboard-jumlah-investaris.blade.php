@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="row w-100">
        <div class="p-3 mt-4 mb-0">
            <h4>Jumlah Investaris</h4>
        </div>
    </div>
    <div class="row row-cols-lg-4 mt-4 justify-content-center">
    <!--Card Pasien-->
    <a href="{{ route('jumlah_inventaris_barang_di_ruang') }}">
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Per-Ruang</h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('jumlah_inventaris_barang_per_kategori') }}">
        <!-- {{ route('ralan-lab') }} -->
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Per-kategori</h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('jumlah_inventaris_barang_per_merk') }}">
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Per-Merk</h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('jumlah_inventaris_barang_per_jenis') }}">
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Per-Jenis</h5>
                            <h4 class="mb-2"></h4>
                            <div class="mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('jumlah_inventaris_barang_per_produsen') }}">
        <div class="col-12 d-flex justify-content-center mb-4">
            <div class="card flex-fill border-0 kotak">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grown-1">
                            <h5 class="mb-2">Per-Produsen</h5>
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

