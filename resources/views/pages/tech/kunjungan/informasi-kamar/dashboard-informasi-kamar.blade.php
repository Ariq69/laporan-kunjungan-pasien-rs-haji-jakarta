@extends('layouts.dashboard')

@section('content')

<style>
    .table-bordered th, .table-bordered td {
        border-width: 2px;
    }

    .scroll-horizontal-vertical thead {
    position: sticky;
    top: 0; /* Ganti dengan warna latar belakang yang sesuai */
    background-color: #fff;
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
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center sticky-header">Nama Ruangan</th>
                                    <th colspan="6" class="text-center sticky-header">Kelas Ruangan</th>
                                    <th style="vertical-align: middle;" rowspan="2" class="text-center sticky-header">Total</th>
                                </tr>
                                <tr>
                                    <th class="text-center sticky-header">Kelas 1</th>
                                    <th class="text-center sticky-header">Kelas 2</th>
                                    <th class="text-center sticky-header">Kelas 3</th>
                                    <th class="text-center sticky-header">Kelas Utama</th>
                                    <th class="text-center sticky-header">Kelas VIP</th>
                                    <th class="text-center sticky-header">Kelas VVIP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($infoKamar as $row)
                                <tr>
                                    <td class="text-justify">{{ $row->nm_bangsal }}</td>
                                    <td class="text-center">{{ $row->Jumlah_Kelas1 }}</td>
                                    <td class="text-center">{{ $row->Jumlah_Kelas2 }}</td>
                                    <td class="text-center">{{ $row->Jumlah_Kelas3 }}</td>
                                    <td class="text-center">{{ $row->Jumlah_KelasUtama }}</td>
                                    <td class="text-center">{{ $row->Jumlah_KelasVIP }}</td>
                                    <td class="text-center">{{ $row->Jumlah_KelasVVIP }}</td>
                                    <td class="text-center">
                                        {{ ($row->Jumlah_Kelas1) + ($row->Jumlah_Kelas2) + ($row->Jumlah_Kelas3) + ($row->Jumlah_KelasUtama) + ($row->Jumlah_KelasVIP) + ($row->Jumlah_KelasVVIP)}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" rowspan="2" colspan="2" class="text-center">Nama Ruangan</th>
                                <th class="text-center" rowspan="2" style="vertical-align: middle;">Kelas</th>
                                <th colspan="4" class="text-center">Status Bed</th>
                                <th style="vertical-align: middle;" rowspan="2" class="text-center">Total</th>
                            </tr>
                            <tr>
                                <th class="text-center">Terisi</th>
                                <th class="text-center">Kosong</th>
                                <th class="text-center">Dibersihkan</th>
                                <th class="text-center">Dibooking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($infoBed as $key => $bed)
                                <tr>
                                    <td colspan="2">{{ $bed->nm_bangsal }}</td>
                                    <td class="text-center">{{ $bed->kelas }}</td>
                                    <td class="text-center">{{ $bed->Jumlah_ISI }}</td>
                                    <td class="text-center">{{ $bed->Jumlah_KOSONG }}</td>
                                    <td class="text-center">{{ $bed->Jumlah_DIBERSIHKAN }}</td>
                                    <td class="text-center">{{ $bed->Jumlah_DIBOOKING }}</td>
                                    <td class="text-center">
                                        {{ ($bed->Jumlah_ISI) + ($bed->Jumlah_DIBOOKING) + ($bed->Jumlah_DIBERSIHKAN) + ($bed->Jumlah_KOSONG) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
