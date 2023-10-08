@extends('layouts.dashboard')

@section('content')
<!--Main Content-->
<main class="content px-3 py-2">
    <div class="container-fluid">
    <div class="mb-3 mt-3">
    <div class="row">
        <div class="col-lg-6 ">
        <h4>Data Pasien</h4>
        </div>
    </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover scroll-horizontal-vertical w-100" id="crudTable_pasien">
        <thead>
            <tr>
            <th scope="col">No.R.M</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">No.SIM/KTP</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Tempat Lahir</th>
            <th scope="col">Tanggal Lahir</th>
            <th scope="col">Nama Ibu</th>
            <th scope="col">Alamat</th>
            <th scope="col">Golongan Darah</th>
            <th scope="col">Pekerjaan</th>
            <th scope="col">Status Nikah</th>
            <th scope="col">Agama</th>
            <th scope="col">Tanggal Daftar</th>
            <th scope="col">No.Telp/HP</th>
            <th scope="col">Umur</th>
            <th scope="col">Pendidikan</th>
            <th scope="col">Penanggung Jawab</th>
            <th scope="col">Nama Penanggung Jawab</th>
            <th scope="col">Asuransi/Askes</th>
            <th scope="col">No.Peserta</th>
            <th scope="col">Pekerjaan Penanggung Jawab</th>
            <th scope="col">Alamat Penanggung Jawab</th>
            <th scope="col">Suku/Bangsa</th>
            <th scope="col">Bahasa</th>
            <th scope="col">Instansi/Perusahaan</th>
            <th scope="col">NIP/NRP</th>
            <th scope="col">Email</th>
            <th scope="col">Cacat Fisik</th>
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
        var datatable = $('#crudTable_pasien').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data:'no_rkm_medis', name:'no_rkm_medis' },
                { data:'nm_pasien', name:'nm_pasien' },
                { data:'no_ktp', name:'no_ktp' },
                { data:'jk', name:'jk' },
                { data:'tmp_lahir', name:'tmp_lahir' },
                { data:'tgl_lahir', name:'tgl_lahir' },
                { data:'nm_ibu', name:'nm_ibu' },
                { data:'alamat', name:'alamat' },
                { data:'gol_darah', name:'gol_darah' },
                { data:'pekerjaan', name:'pekerjaan' },
                { data:'stts_nikah', name:'stts_nikah' },
                { data:'agama', name:'agama' },
                { data:'tgl_daftar', name:'tgl_daftar' },
                { data:'no_tlp', name:'no_tlp' },
                { data:'umur', name:'umur' },
                { data:'pnd', name:'pnd' },
                { data:'keluarga', name:'keluarga' },
                { data:'namakeluarga', name:'namakeluarga' },
                { data:'penjab.png_jawab', name:'penjab.png_jawab' },
                { data:'no_peserta', name:'no_peserta' },
                { data:'pekerjaanpj', name:'pekerjaanpj' },
                { data:'alamatpj', name:'alamatpj' },
                { data:'suku.nama_suku_bangsa', name:'suku.nama_suku_bangsa' },
                { data:'bahasa.nama_bahasa', name:'bahasa.nama_bahasa' },
                { data:'perusahaan_pasien', name:'perusahaan_pasien' },
                { data:'nip', name:'nip' },
                { data:'email', name:'email' },
                { data:'cacatfisik.nama_cacat', name:'cacatfisik.nama_cacat' },
            ],
        })
    </script>
@endpush
