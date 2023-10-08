<?php

namespace App\Http\Controllers\Tech;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function data_pegawai(){
        if (request()->ajax()) {
            $pegawai = Pegawai::with(['jabatan']);

            return Datatables::of($pegawai)->make(true);
        }
        return view('pages.tech.pegawai.dashboard-data-pegawai');
    }
}
