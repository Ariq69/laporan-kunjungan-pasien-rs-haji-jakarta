<?php

namespace App\Http\Controllers\Tech;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class IGDController extends Controller
{
    public function dashboard_igd(){
        return view('pages.tech.kunjungan.igd.dashboard-igd');
    }
}
