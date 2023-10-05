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
        <div class="col-lg-6">
        <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
        </div>
    </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead>
            <tr>
            <th scope="col">Kode Dokter</th>
            <th scope="col">Nama Dokter</th>
            <th scope="col">Hari Kerja</th>
            <th scope="col">Jam Mulai</th>
            <th scope="col">Jam Selesai</th>
            <th scope="col">Poliklinik</th>
            <th scope="col">Kuota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
            <td>30</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
            <td>30</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
            <td>30</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
            <td>30</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
            <td>30</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
            <td>30</td>
            </tr>
        </tbody>
        </table>
        </div>
    </div>
    </div>
</main>
@endsection
