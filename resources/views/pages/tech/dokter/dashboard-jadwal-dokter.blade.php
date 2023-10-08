@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
        <div class="col-lg-6 ">
        <h4>Jadwal Dokter</h4>
        </div>
    </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_jadwal_dokter">
        <thead>
            <tr>
            <th scope="col">Nama Dokter</th>
            <th scope="col">Hari Kerja</th>
            <th scope="col">Jam Mulai</th>
            <th scope="col">Jam Selesai</th>
            <th scope="col">Poliklinik</th>
            <th scope="col">Kuota</th>
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
        var datatable = $('#crudTable_jadwal_dokter').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'dokter.nm_dokter', name:'dokter.nm_dokter' },
                { data:'hari_kerja', name:'hari_kerja' },
                { data:'jam_mulai', name:'jam_mulai' },
                { data:'jam_selesai', name:'jam_selesai' },
                { data:'poli.nm_poli', name:'poli.nm_poli' },
                { data:'kuota', name:'kuota' },
            ],
        })
    </script>
@endpush
