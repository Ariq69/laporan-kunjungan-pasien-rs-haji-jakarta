<?php

namespace App\Http\Controllers\tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KeslingPemakaianAirPdam;

class K3Controller extends Controller
{
    public function k3(){
        return view('pages.tech.k3.dashboard-k3');
    }
}

