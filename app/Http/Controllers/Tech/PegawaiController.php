<?php

namespace App\Http\Controllers\Tech;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function data_pegawai(){
        $jumlahPegawaiPerJabatan = DB::table('pegawai')
        ->select('jbtn', DB::raw('COUNT(*) as jumlah_pegawai'))
        ->where('stts_aktif', 'AKTIF')
        ->groupBy('jbtn')
        ->get();

        $queryPegawai = $jumlahPegawaiPerJabatan->mapWithKeys(function ($item){
            return [$item->jbtn => $item->jumlah_pegawai];
        });

        return view('pages.tech.pegawai.dashboard-data-pegawai', compact(
            'queryPegawai',
        ));

    }
}
