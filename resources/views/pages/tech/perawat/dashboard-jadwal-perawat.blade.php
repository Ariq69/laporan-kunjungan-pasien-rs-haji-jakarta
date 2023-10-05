@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
<div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
    <div class="col-lg-6 ">
        <h4>Jadwal Perawat</h4>
    </div>
    <div class="col-lg-6">
        <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Kode Perawat</th>
            <th scope="col">Nama Perawat</th>
            <th scope="col">Hari Kerja</th>
            <th scope="col">Jam Mulai</th>
            <th scope="col">Jam Selesai</th>
            <th scope="col">Poliklinik</th>
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
        </tr>
        <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
        </tr>
        <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
        </tr>
        <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
        </tr>
        <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
        </tr>
        <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>Selasa</td>
            <td>07:00:00</td>
            <td>09:00:00</td>
            <td>Poliklinik THT</td>
        </tr>
        
        </tbody>
    </table>
    </div>
</div>
</main>
@endsection
