<?php

namespace App\Http\Controllers;

use Model\User;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pegawai;
use App\Models\Spesialis;
use App\Models\KamarPasien;
use App\Models\RegistrasiPasien;
use Illuminate\Http\Request;
use App\Models\JadwalPerawat;
use App\Models\Penjab;
use Illuminate\Support\Facades\Auth;

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
        $jumlah_pasien = number_format(Pasien::count());
        $jumlah_dokter = number_format(Dokter::count());
        $jumlah_perawat = number_format(JadwalPerawat::where('stts_aktif', 'AKTIF')->count());
        $jumlah_pegawai = number_format(Pegawai::count());
        $jumlah_poli = number_format(Spesialis::count());
        $jumlah_kamar = number_format(KamarPasien::count());
        $jumlah_asuransi = number_format(Penjab::count());

        
        


        return view('pages.tech.dashboard', [
            'jumlah_pasien' => $jumlah_pasien,
            'jumlah_dokter' => $jumlah_dokter,
            'jumlah_perawat' => $jumlah_perawat,
            'jumlah_pegawai' => $jumlah_pegawai,
            'jumlah_poli' => $jumlah_poli,
            'jumlah_kamar' => $jumlah_kamar,
            'jumlah_asuransi' => $jumlah_asuransi,
        ]);
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
