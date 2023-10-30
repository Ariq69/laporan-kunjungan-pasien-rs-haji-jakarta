@extends('layouts.dashboard')

@section('content')

<style>
    .table-bordered th, .table-bordered td {
        border-width: 2px;
    }
</style>

<!--Main Content-->
<main class="content px-3 py-2">
    <!-- TABLE INFORMASI KAMAR -->
    <div class="container-fluid">
    <div class="row">
            <section class="haji-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('informasi-kamar') }}">Informasi Kamar</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
        </section>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5>Informasi Ruangan</h5>
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 500px;">
                        <table class="table table-bordered table-striped table-hover scroll-horizontal-vertical w-100">
                        <tr>
                            <th style="vertical-align: middle;" rowspan="2" class="text-center">Nama Ruangan</th>
                            <th colspan="6" class="text-center">Kelas Ruangan</th>
                        </tr>
                        <tr>
                            <th class="text-center">Kelas 1</th>
                            <th class="text-center">Kelas 2</th>
                            <th class="text-center">Kelas 3</th>
                            <th class="text-center">Kelas Utama</th>
                            <th class="text-center">Kelas VIP</th>
                            <th class="text-center">Kelas VVIP</th>
                        </tr>
                        @foreach($infoKamar as $row)
                        <tr>
                            <td class="text-justify">{{ $row->nm_bangsal }}</td>
                            <td class="text-center">{{ $row->Jumlah_Kelas1 }}</td>
                            <td class="text-center">{{ $row->Jumlah_Kelas2 }}</td>
                            <td class="text-center">{{ $row->Jumlah_Kelas3 }}</td>
                            <td class="text-center">{{ $row->Jumlah_KelasUtama }}</td>
                            <td class="text-center">{{ $row->Jumlah_KelasVIP }}</td>
                            <td class="text-center">{{ $row->Jumlah_KelasVVIP }}</td>
                        </tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- TABLE INFORMASI BED -->
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5>Informasi Bed</h5>
                <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 500px;">
                    <table class="table table-bordered table-striped table-hover scroll-horizontal-vertical w-100">
                        <tr>
                            <th style="vertical-align: middle;" rowspan="2" colspan="2" class="text-center">Nama Ruangan</th>
                            <th class="text-center" rowspan="2" style="vertical-align: middle;">Kelas</th>
                            <th colspan="4" class="text-center">Status Bed</th>
                        </tr>
                        <tr>
                            <th class="text-center">Terisi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                        </tr>
                        <!-- <tr>
                            <th class="text-center" colspan="4">Kelas 1</th>
                            <th class="text-center" colspan="4">Kelas 2</th>
                            <th class="text-center" colspan="4">Kelas 3</th>
                            <th class="text-center" colspan="4">Kelas Utama</th>
                            <th class="text-center" colspan="4">Kelas VIP</th>
                            <th class="text-center" colspan="4">Kelas VVIP</th>
                        </tr> -->
                        <!-- <tr>
                            <th class="text-center">Isi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                            <th class="text-center">Isi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                            <th class="text-center">Isi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                            <th class="text-center">Isi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                            <th class="text-center">Isi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                            <th class="text-center">Isi</th>
                            <th class="text-center">Kosong</th>
                            <th class="text-center">Dibersihkan</th>
                            <th class="text-center">Dibooking</th>
                        </tr> -->
                        @foreach($infoBed as $row)
                            <tr>
                                <td colspan="2">{{ $row->nm_bangsal }}</td>
                                <td class="text-center">{{ $row->kelas }}</td>
                                <td class="text-center">{{ $row->Jumlah_ISI }}</td>
                                <td class="text-center">{{ $row->Jumlah_KOSONG }}</td>
                                <td class="text-center">{{ $row->Jumlah_DIBERSIHKAN }}</td>
                                <td class="text-center">{{ $row->Jumlah_DIBOOKING }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
