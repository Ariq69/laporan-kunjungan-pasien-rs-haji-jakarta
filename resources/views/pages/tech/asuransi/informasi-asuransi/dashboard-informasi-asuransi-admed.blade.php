@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row mb-3">
        <div class="col-lg-6 ">
        <h4>Informasi Asuransi ADMEDIKA</h4>
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
                                <h4 class="mb-2 text-light">h</h4>
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
                                <h4 class="mb-2 text-light">h</h4>
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
                                <h4 class="mb-2">h</h4>
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
                                <h4 class="mb-2 text-light">h</h4>
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
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_asuransi_admed">
                <thead>
                    <tr>
                        <th scope="col">Kode Asuransi</th>
                        <th scope="col">Nama Asuransi</th>
                            <th scope="col">Nama Perusahaan</th>
                        <th scope="col">Alamat Asuransi</th>
                        <th scope="col">No.Telp</th>
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
        var datatable = $('#crudTable_asuransi_admed').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'kd_pj', name:'kd_pj' },
                { data:'png_jawab', name:'png_jawab' },
                { data:'nama_perusahaan', name:'nama_perusahaan' },
                { data:'alamat_asuransi', name:'alamat_asuransi' },
                { data:'no_telp', name:'no_telp' },
            ],
        })
    </script>
@endpush
