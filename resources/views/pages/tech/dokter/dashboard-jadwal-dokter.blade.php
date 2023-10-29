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
                <table class="table table-striped table-hover scroll-horizontal-vertical w-100">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;" rowspan="2" class="text-center">Nama Dokter</th>
                            <th colspan="5" class="text-center">Hari</th>
                            <th style="vertical-align: middle;" rowspan="2" class="text-center">Poliklinik</th>
                        </tr>
                        <tr>
                            <th class="text-center">Senin</th>
                            <th class="text-center">Selasa</th>
                            <th class="text-center">Rabu</th>
                            <th class="text-center">Kamis</th>
                            <th class="text-center">Jumat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwaldokter as $nm_dokter => $jadwalDetails)
                            <tr>
                                <td>{{ $nm_dokter }}</td>
                                <td class="text-center">
                                    @if ($senin = $jadwalDetails->firstWhere('hari_kerja', 'SENIN'))
                                        {{ $senin->jam_mulai }} - {{ $senin->jam_selesai }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($selasa = $jadwalDetails->firstWhere('hari_kerja', 'SELASA'))
                                        {{ $selasa->jam_mulai }} - {{ $selasa->jam_selesai }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($rabu = $jadwalDetails->firstWhere('hari_kerja', 'RABU'))
                                        {{ $rabu->jam_mulai }} - {{ $rabu->jam_selesai }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($kamis = $jadwalDetails->firstWhere('hari_kerja', 'KAMIS'))
                                        {{ $kamis->jam_mulai }} - {{ $kamis->jam_selesai }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($jumat = $jadwalDetails->firstWhere('hari_kerja', 'JUMAT'))
                                        {{ $jumat->jam_mulai }} - {{ $jumat->jam_selesai }}
                                    @endif
                                </td>
                                <td>{{ $jadwalDetails->first()->nm_poli }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
