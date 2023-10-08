@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
        <div class="col-lg-6 ">
        <h4>Data Pasien Lama</h4>
        </div>
    </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_pasien_lama">
        <thead>
            <tr>
            <th scope="col">No.Registrasi</th>
            <th scope="col">No.Rawat</th>
            <th scope="col">Tanggal Registrasi</th>
            <th scope="col">Jam Registrasi</th>
            <th scope="col">Dokter</th>
            <th scope="col">No.R.M</th>
            <th scope="col">Poliklinik</th>
            <th scope="col">Penanggung Jawab</th>
            <th scope="col">Alamat Penanggung Jawab</th>
            <th scope="col">Hubungan Penanggung Jawab</th>
            <th scope="col">Biaya Registrasi</th>
            <th scope="col">Status Pasien</th>
            <th scope="col">Status Rawat</th>
            <th scope="col">Asuransi/Askes</th>
            <th scope="col">Status Bayar</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        </div>
    </div>
    </div>
</main>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable_pasien_lama').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'no_reg', name:'no_reg' },
                { data:'no_rawat', name:'no_rawat' },
                { data:'tgl_registrasi', name:'tgl_registrasi' },
                { data:'jam_reg', name:'jam_reg' },
                { data:'reg_dokter.nm_dokter', name:'reg_dokter.nm_dokter' },
                { data:'no_rkm_medis', name:'no_rkm_medis' },
                { data:'poli.nm_poli', name:'poli.nm_poli' },
                { data:'p_jawab', name:'p_jawab' },
                { data:'almt_pj', name:'almt_pj' },
                { data:'hubunganpj', name:'hubunganpj' },
                { data:'biaya_reg', name:'biaya_reg' },
                { data:'stts_daftar', name:'stts_daftar' },
                { data:'status_lanjut', name:'status_lanjut' },
                { data:'penjab.png_jawab', name:'penjab.png_jawab' },
                { data:'status_bayar', name:'status_bayar' },
            ],
        })
    </script>
@endpush
