@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
        <div class="col-lg-6 ">
        <h4>Daftar Pengguna</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
                <a href="{{ route('setting-pengguna.create') }}" class="btn btn-primary mb-3">
                    + Tambah User Baru
                </a>
                <div class="table-responsive">
                    <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    </div>
    </div>
</main>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{{ route("setting-pengguna") }}',
            },
            columns: [
                { data:'id', name:'id' },
                { data:'name', name:'name' },
                { data:'email', name:'email' },
                { data:'roles', name:'roles' },
                { 
                    data:'action', 
                    name:'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ],
        })
    </script>
@endpush