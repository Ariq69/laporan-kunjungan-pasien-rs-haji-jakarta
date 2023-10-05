@extends('layouts.dashboard')

@section('content')
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
        <div class="col-lg-6 ">
        <h4>Data Perawat</h4>
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
            <th scope="col">Kode Perawat</th>
            <th scope="col">Nama Perawat</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Tempat Lahir</th>
            <th scope="col">Gol. Darah</th>
            <th scope="col">Agama</th>
            <th scope="col">Alamat</th>
            <th scope="col">No.HP/Telp</th>
            <th scope="col">Status Nikah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>P</td>
            <td>Depok</td>
            <td>1985-09-22</td>
            <td>A</td>
            <td>Islam</td>
            <td>-</td>
            <td>Menikah</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>P</td>
            <td>Depok</td>
            <td>1985-09-22</td>
            <td>A</td>
            <td>Islam</td>
            <td>-</td>
            <td>Menikah</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>P</td>
            <td>Depok</td>
            <td>1985-09-22</td>
            <td>A</td>
            <td>Islam</td>
            <td>-</td>
            <td>Menikah</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>P</td>
            <td>Depok</td>
            <td>1985-09-22</td>
            <td>A</td>
            <td>Islam</td>
            <td>-</td>
            <td>Menikah</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>P</td>
            <td>Depok</td>
            <td>1985-09-22</td>
            <td>A</td>
            <td>Islam</td>
            <td>-</td>
            <td>Menikah</td>
            </tr>
            <tr>
            <th scope="row">D0000006</th>
            <td>dr. Aisyah</td>
            <td>P</td>
            <td>Depok</td>
            <td>1985-09-22</td>
            <td>A</td>
            <td>Islam</td>
            <td>-</td>
            <td>Menikah</td>
            </tr>
        </tbody>
        </table>
        </div>
    </div>
    </div>
</main>
@endsection
