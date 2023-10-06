<?php

namespace App\Http\Controllers\Tech;

use App\Models\Pasien;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PasienController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth',['tech']);
        }

    public function pasien(){
            
            if (request()->ajax()) {
            $data_pasien = Pasien::select('*');

            return Datatables::of($data_pasien)->make(true);
        }

        return view('pages.tech.pasien.dashboard-pasien');
    }
        
    public function informasi_kamar(){
            
            if (request()->ajax()) {
            $data_pasien = Pasien::select('*');

            return Datatables::of($data_pasien)->make(true);
        }

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar');
    }
}
