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
use Illuminate\Support\Facades\DB;

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


    public function tech(Request $request)
    {
        $jumlah_pasien = number_format(Pasien::count());
        $jumlah_dokter = number_format(Dokter::count());
        $jumlah_perawat = number_format(JadwalPerawat::where('stts_aktif', 'AKTIF')->count());
        $jumlah_pegawai = number_format(Pegawai::count());
        $jumlah_kamar = number_format(KamarPasien::count());
        $jumlah_ralan_formatted = DB::table('reg_periksa')
        ->where('status_lanjut', 'Ralan')
        ->count();
    
        $jumlah_ralan = number_format($jumlah_ralan_formatted);
    
        $jumlah_ranap_formatted = DB::table('reg_periksa')
        ->where('status_lanjut', 'Ranap')
        ->count();

        $jumlah_ranap = number_format($jumlah_ranap_formatted);

        $jumlah_igdk_formatted = DB::table('reg_periksa')->where('kd_poli', 'IGDK')->count();

        $jumlah_igd01_formatted = DB::table('reg_periksa')->where('kd_poli', 'IGD01')->count();

        $jumlah_igd = number_format($jumlah_igdk_formatted + $jumlah_igd01_formatted);


        // Buat Bar Chart Kunjungan Pasien
        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $permonths = DB::table('reg_periksa')
            ->select(DB::raw('DATE(tgl_registrasi) as tanggal'), DB::raw('COUNT(*) as total_kunjungan'))
            ->whereYear('tgl_registrasi', $year)
            ->whereMonth('tgl_registrasi', $month)
            ->groupBy(DB::raw('CAST(tgl_registrasi AS DATE)'))
            ->orderBy('tanggal')
            ->get();

        $three_months = DB::table('reg_periksa')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 3) + 1 AS periode'),
                DB::raw("CASE 
                    WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 3 THEN 'Januari - Maret'
                    WHEN MONTH(tgl_registrasi) BETWEEN 4 AND 6 THEN 'April - Juni'
                    WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 9 THEN 'Juli - September'
                    WHEN MONTH(tgl_registrasi) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
                    ELSE 'Tidak Valid'
                END AS keterangan_periode"),
                DB::raw('COUNT(*) AS total_kunjungan')
            ])
            ->whereYear('tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->orderBy('tahun')
            ->orderBy('periode')
            ->get();

        $six_months = DB::table('reg_periksa')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 6) + 1 AS periode'),
                DB::raw("CASE 
                    WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 6 THEN 'Januari - Juni'
                    WHEN MONTH(tgl_registrasi) BETWEEN 7 AND 12 THEN 'Juli - Desember'
                    ELSE 'Tidak Valid'
                END AS keterangan_periode"),
                DB::raw('COUNT(*) AS total_kunjungan')
            ])
            ->whereYear('tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->orderBy('tahun')
            ->orderBy('periode')
            ->get();

        $one_years = DB::table('reg_periksa')
            ->select([
                DB::raw('YEAR(tgl_registrasi) AS tahun'),
                DB::raw('FLOOR((MONTH(tgl_registrasi) - 1) / 12) + 1 AS periode'),
                DB::raw("CASE 
                    WHEN MONTH(tgl_registrasi) BETWEEN 1 AND 12 THEN 'Januari - Desember'
                    ELSE 'Tidak Valid'
                END AS keterangan_periode"),
                DB::raw('COUNT(*) AS total_kunjungan')
            ])
            ->whereYear('tgl_registrasi', $year)
            ->groupBy('tahun', 'periode', 'keterangan_periode')
            ->orderBy('tahun')
            ->orderBy('periode')
            ->get();

        $query = [];

        if ($request->input('triwulan')) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjungan];
            });
        } elseif ($request->input('semester')) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjungan];
            });
        } elseif ($request->input('tahunan')) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjungan];
            });
        } elseif ($request->input('month')) {
            $query = $permonths->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjungan];
            });
        }


        //dd($query);

        return view('pages.tech.dashboard', [
            'jumlah_pasien' => $jumlah_pasien,
            'jumlah_dokter' => $jumlah_dokter,
            'jumlah_ralan' => $jumlah_ralan,
            'jumlah_pegawai' => $jumlah_pegawai,
            'jumlah_kamar' => $jumlah_kamar,
            'jumlah_ranap' => $jumlah_ranap,
            'jumlah_igd' => $jumlah_igd,
            'years' => $years,
            'query' => $query,
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
