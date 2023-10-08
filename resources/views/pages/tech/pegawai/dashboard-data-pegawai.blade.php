@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
        <div class="col-lg-6 ">
        <h4>Data Pegawai</h4>
        </div>
        <div class="col-lg-6">
        </div>
    </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_data_pegawai">
        <thead>
            <tr>
            <th scope="col">Kode Pegawai</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Tempat Lahir</th>
            <th scope="col">Tanggal Lahir</th>
            <th scope="col">Gol. Darah</th>
            <th scope="col">Agama</th>
            <th scope="col">Status Nikah</th>
            <th scope="col">Alamat</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody></tbody>
        </table>
        </div>
    </div>
    </div>
</main>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable_data_pegawai').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'nip', name:'nip' },
                { data:'nama', name:'nama' },
                { data:'jk', name:'jk' },
                { data:'tmp_lahir', name:'tmp_lahir' },
                { data:'tgl_lahir', name:'tgl_lahir' },
                { data:'gol_darah', name:'gol_darah' },
                { data:'agama', name:'agama' },
                { data:'stts_nikah', name:'stts_nikah' },
                { data:'alamat', name:'alamat' },
                { data:'jabatan.nm_jbtn', name:'jabatan.nm_jbtn' },
                { data:'status', name:'status' },
            ],
        })
    </script>
@endpush
