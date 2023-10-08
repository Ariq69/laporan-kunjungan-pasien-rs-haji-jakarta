<?php

namespace App\Http\Controllers\Tech;

use App\Http\Controllers\Controller;
use App\Models\JadwalPerawat;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class PerawatController extends Controller
{
    public function data_perawat(){
        if (request()->ajax()) {
            $jadwal_perawat = JadwalPerawat::select('*')->where('stts_aktif', 'AKTIF');

            return Datatables::of($jadwal_perawat)->make(true);
        }
        return view('pages.tech.perawat.dashboard-data-perawat');
    }
    public function jadwal_perawat(){
        return view('pages.tech.perawat.dashboard-jadwal-perawat');
    }
}
