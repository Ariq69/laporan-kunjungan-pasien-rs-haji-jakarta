<?php

namespace App\Http\Controllers\Tech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['tech']);
    }

    public function index(){
        return view('pages.tech.dashboard');
    }
}
