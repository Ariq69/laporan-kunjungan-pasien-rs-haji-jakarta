<?php

namespace App\Http\Controllers\Tech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function data_perawat(){
        return view('pages.tech.perawat.dashboard-data-perawat');
    }
    public function jadwal_perawat(){
        return view('pages.tech.perawat.dashboard-jadwal-perawat');
    }
}
