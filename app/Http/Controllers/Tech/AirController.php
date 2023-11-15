<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AirController extends Controller
{
    public function air_pdam(){
        return view('pages.tech.pemakaian-air.dashboard-air-pdam');
    }
}

