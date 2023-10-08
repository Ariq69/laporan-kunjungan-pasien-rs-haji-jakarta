@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row mb-3">
        <div class="col-lg-6 ">
        <h4>Informasi Kamar SAKINAH</h4>
        </div>
    </div>

    <div class="row row-cols-lg-4 mt-4">
            <!--Card Informasi Kamar-->
            <a href="">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4 bg-primary">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2 text-light">Informasi Kamar</h5>
                                <h4 class="mb-2 text-light">{{ $informasi_kamar_sak }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            <!--Card Jumlah Kamar Isi-->
            <a href="">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4 bg-success">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2 text-light">ISI</h5>
                                <h4 class="mb-2 text-light">{{ $informasi_kamar_isi }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            <!--Card Jumlah Kamar Booking-->
            <a href="">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4 bg-warning">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2 ">BOOKING</h5>
                                <h4 class="mb-2">{{ $informasi_kamar_booking }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            <!--Card Jumlah Kosong-->
            <a href="">
            <div class="col-12 d-flex">
                <div class="card flex-fill border-0">
                    <div class="card-body py-4 bg-danger">
                        <div class="d-flex align-items-start">
                            <div class="flex-grown-1">
                                <h5 class="mb-2 text-light">KOSONG</h5>
                                <h4 class="mb-2 text-light">{{ $informasi_kamar_kosong }}</h4>
                                <div class="mb-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <div class="row mb-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_kamar_afiah">
                <thead>
                    <tr>
                        <th scope="col">Kode Kamar</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable_kamar_afiah').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'kd_kamar', name:'kd_kamar' },
                { data:'kelas', name:'kelas' },
                { data:'trf_kamar', name:'trf_kamar' },
                { data:'status', name:'status' },
            ],
        })
    </script>
@endpush
