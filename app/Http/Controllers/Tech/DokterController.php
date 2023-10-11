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
            
            $dokter = Dokter::get()->toArray();

            if (request()->ajax()) {
            $data_dokter = Dokter::with(['spesialis']);

            return Datatables::of($data_dokter)->make(true);
        }

        return view('pages.tech.dokter.dashboard-data-dokter',[
            'dokter' => $dokter,
        ]);
    }
        
        public function jadwal_dokter(){
            
            if (request()->ajax()) {
            $jadwal_dokter = JadwalDokter::with('dokter','poli');

            return Datatables::of($jadwal_dokter)->make(true);
        }

        return view('pages.tech.dokter.dashboard-jadwal-dokter');
    }
}
