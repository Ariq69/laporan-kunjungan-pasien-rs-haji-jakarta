<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Model\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->roles == 'tech'){
            return redirect('/dashboard/tech');
        }elseif (Auth::user()->roles == 'admin'){
            return redirect('/dashboard/admin');
        }elseif (Auth::user()->roles == 'dokter'){
            return redirect('/dashboard/dokter');
        }elseif (Auth::user()->roles == 'perawat'){
            return redirect('/dashboard/perawat');
        }elseif (Auth::user()->roles == 'pegawai'){
            return redirect('/dashboard/pegawai');
        }elseif (Auth::user()->roles == 'direksi'){
            return redirect('/dashboard/direksi');
        }
    }


    public function tech()
    {
        return view('pages.tech.dashboard');
    }

    public function admin()
    {
        return view('pages.admin.dashboard');
    }

    public function dokter()
    {
        return view();
    }

    public function perawat()
    {
        return view();
    }

    public function pegawai()
    {
        return view('pages.pegawai.dashboard');
    }

    public function direksi()
    {
        return view();
    }
}
