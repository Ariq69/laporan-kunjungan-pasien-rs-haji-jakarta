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

        <div class="row mb-4">
            <div class="col-lg-6 ">
                <h6>Kamar : AFIAH</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_pasien">
                <thead>
                    <tr>
                        <th scope="col">Kode Kamar</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 1</td>
                        <td>750.000</td>
                        <td>DIBOOKING</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 2</td>
                        <td>500.000</td>
                        <td>ISI</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 3</td>
                        <td>300.000</td>
                        <td>KOSONG</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 ">
                <h6>Kamar : AFIAH ISOLASI</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_pasien">
                <thead>
                    <tr>
                        <th scope="col">Kode Kamar</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 1</td>
                        <td>750.000</td>
                        <td>DIBOOKING</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 2</td>
                        <td>500.000</td>
                        <td>ISI</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 3</td>
                        <td>300.000</td>
                        <td>KOSONG</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 ">
                <h6>Kamar : AMANAH</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_pasien">
                <thead>
                    <tr>
                        <th scope="col">Kode Kamar</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 1</td>
                        <td>750.000</td>
                        <td>DIBOOKING</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 2</td>
                        <td>500.000</td>
                        <td>ISI</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 3</td>
                        <td>300.000</td>
                        <td>KOSONG</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 ">
                <h6>Kamar : AFIAH BAYI</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_pasien">
                <thead>
                    <tr>
                        <th scope="col">Kode Kamar</th>
                        <th scope="col">Tarif</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 1</td>
                        <td>750.000</td>
                        <td>DIBOOKING</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 2</td>
                        <td>500.000</td>
                        <td>ISI</td>
                    </tr>
                    <tr>
                        <td>AFI.KL 1.10.01 Kelas 3</td>
                        <td>300.000</td>
                        <td>KOSONG</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection

@push('addon-script')
    {{-- <script>
        var datatable = $('#crudTable_pasien').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'no_rkm_medis', name:'no_rkm_medis' },
                { data:'nm_pasien', name:'nm_pasien' },
                { data:'no_ktp', name:'no_ktp' },
                { data:'jk', name:'jk' },
                { data:'tmp_lahir', name:'tmp_lahir' },
                { data:'tgl_lahir', name:'tgl_lahir' },
                { data:'nm_ibu', name:'nm_ibu' },
                { data:'alamat', name:'alamat' },
                { data:'gol_darah', name:'gol_darah' },
                { data:'pekerjaan', name:'pekerjaan' },
                { data:'stts_nikah', name:'stts_nikah' },
                { data:'agama', name:'agama' },
                { data:'tgl_daftar', name:'tgl_daftar' },
                { data:'no_tlp', name:'no_tlp' },
                { data:'umur', name:'umur' },
                { data:'pnd', name:'pnd' },
                { data:'keluarga', name:'keluarga' },
                { data:'namakeluarga', name:'namakeluarga' },
                { data:'kd_pj', name:'kd_pj' },
                { data:'no_peserta', name:'no_peserta' },
                { data:'pekerjaanpj', name:'pekerjaanpj' },
                { data:'alamatpj', name:'alamatpj' },
                { data:'suku_bangsa', name:'suku_bangsa' },
                { data:'bahasa_pasien', name:'bahasa_pasien' },
                { data:'perusahaan_pasien', name:'perusahaan_pasien' },
                { data:'nip', name:'nip' },
                { data:'email', name:'email' },
                { data:'cacat_fisik', name:'cacat_fisik' },
            ],
        })
    </script> --}}
@endpush
