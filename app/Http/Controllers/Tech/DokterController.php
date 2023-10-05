<?php

namespace App\Http\Controllers\Tech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['tech']);
    }

    public function data_dokter(){
        return view('pages.tech.dokter.dashboard-data-dokter');
    }
    public function jadwal_dokter(){
        return view('pages.tech.dokter.dashboard-jadwal-dokter');
    }
}
