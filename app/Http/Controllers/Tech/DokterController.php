<?php

namespace App\Http\Controllers\Tech;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DokterController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth',['tech']);
        }

        public function data_dokter(){
            
            if (request()->ajax()) {
            $data_dokter = Dokter::select('*');

            return Datatables::of($data_dokter)->make(true);
        }

        return view('pages.tech.dokter.dashboard-data-dokter');
    }
        
        public function jadwal_dokter(){
            
            if (request()->ajax()) {
            $jadwal_dokter = JadwalDokter::select('*');

            return Datatables::of($jadwal_dokter)->make(true);
        }

        return view('pages.tech.dokter.dashboard-jadwal-dokter');
    }
}
