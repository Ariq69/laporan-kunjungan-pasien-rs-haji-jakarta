<?php

namespace App\Http\Controllers\Tech;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RegistrasiPasien;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\JnsPerawatabRadiologi;
use App\Models\PeriksaRadiologi;

class RanapController extends Controller
{
    public function ranap_lab(Request $request) {
        $years = DB::table('periksa_lab')
            ->select(DB::raw('YEAR(tgl_periksa) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        
        $pemeriksaan = DB::table('periksa_lab as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
        ->whereYear('p.tgl_periksa', $year)
        ->whereMonth('p.tgl_periksa', $month)
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->where('p.status', 'ranap')
        ->groupBy(DB::raw('CAST(p.tgl_periksa AS DATE)'))
        ->orderBy('tanggal')
        ->get();
       

        $three_months = DB::table('periksa_lab as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select([
            DB::raw('YEAR(p.tgl_periksa) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tgl_periksa) - 1) / 3) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tgl_periksa) BETWEEN 1 AND 3 THEN 'Januari - Maret'
            WHEN MONTH(p.tgl_periksa) BETWEEN 4 AND 6 THEN 'April - Juni'
            WHEN MONTH(p.tgl_periksa) BETWEEN 7 AND 9 THEN 'Juli - September'
            WHEN MONTH(p.tgl_periksa) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS total_kunjunganlabranap')
        ])
        ->whereYear('p.tgl_periksa', $year)
        ->where('p.status', 'ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        
        // dd($three_months);

        $six_months = DB::table('periksa_lab as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select([
            DB::raw('YEAR(p.tgl_periksa) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tgl_periksa) - 1) / 6) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tgl_periksa) BETWEEN 1 AND 6 THEN 'Januari - Juni'
            WHEN MONTH(p.tgl_periksa) BETWEEN 7 AND 12 THEN 'Juli - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS total_kunjunganlabranap')
        ])
        ->whereYear('p.tgl_periksa', $year)
        ->where('p.status', 'ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        // dd($six_months);

        $one_years = DB::table('periksa_lab as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select([
            DB::raw('YEAR(p.tgl_periksa) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tgl_periksa) - 1) / 12) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tgl_periksa) BETWEEN 1 AND 12 THEN 'Januari - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS total_kunjunganlabranap')
        ])
        ->whereYear('p.tgl_periksa', $year)
        ->where('p.status', 'ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        // dd($one_years);
    
        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjunganlabranap];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjunganlabranap];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->total_kunjunganlabranap];
            });
        } elseif ($request->input('month') ) {
            $query = $pemeriksaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        }

        //dd($query);
        return view('pages.tech.kunjungan.rawat-inap.dashboard-ranap-lab', compact('years', 'query'));
    }

    public function ranap_hemodialisa(Request $request){
        
        $years = DB::table('hemodialisa')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        

        $results = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->where('periksa.status_lanjut', 'Ralan')
        ->where('periksa.kd_poli', '!=', 'IGD01')
        ->where('periksa.kd_poli', '!=', 'IGDK')
        ->whereYear('hemo.tanggal', $year)
        ->whereMonth('hemo.tanggal', $month)
        ->select(DB::raw('DATE(hemo.tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah_kunjungan'))
        ->groupBy(DB::raw('DATE(tanggal)'))
        ->get();
        //dd($results);
        
        $three_months = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->select([
            DB::raw('YEAR(hemo.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(hemo.tanggal) - 1) / 3) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(hemo.tanggal) BETWEEN 1 AND 3 THEN 'Januari - Maret'
            WHEN MONTH(hemo.tanggal) BETWEEN 4 AND 6 THEN 'April - Juni'
            WHEN MONTH(hemo.tanggal) BETWEEN 7 AND 9 THEN 'Juli - September'
            WHEN MONTH(hemo.tanggal) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_kunjungan')
        ])
        ->where('periksa.status_lanjut', 'Ralan')
        ->where('periksa.kd_poli', '!=', 'IGD01')
        ->where('periksa.kd_poli', '!=', 'IGDK')
        ->whereYear('hemo.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();        
        // dd($three_months);

        $six_months = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->select([
            DB::raw('YEAR(hemo.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(hemo.tanggal) - 1) / 6) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(hemo.tanggal) BETWEEN 1 AND 6 THEN 'Januari - Juni'
            WHEN MONTH(hemo.tanggal) BETWEEN 7 AND 12 THEN 'Juli - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_kunjungan')
        ])
        ->where('periksa.status_lanjut', 'Ralan')
        ->where('periksa.kd_poli', '!=', 'IGD01')
        ->where('periksa.kd_poli', '!=', 'IGDK')
        ->whereYear('hemo.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get(); 
        // dd($six_months);

        $one_years = DB::table('hemodialisa as hemo')
        ->join('reg_periksa as periksa', 'hemo.no_rawat', '=', 'periksa.no_rawat')
        ->select([
            DB::raw('YEAR(hemo.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(hemo.tanggal) - 1) / 12) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(hemo.tanggal) BETWEEN 1 AND 12 THEN 'Januari - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_kunjungan')
        ])
        ->where('periksa.status_lanjut', 'Ralan')
        ->where('periksa.kd_poli', '!=', 'IGD01')
        ->where('periksa.kd_poli', '!=', 'IGDK')
        ->whereYear('hemo.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get(); 
        // dd($one_years);
        
        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_kunjungan];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_kunjungan];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_kunjungan];
            });
        } elseif ($request->input('month') ) {
            $query = $results->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->jumlah_kunjungan];
            });
        }


        return view('pages.tech.kunjungan.rawat-inap.dashboard-ranap-hemodialisa',compact('years','query'));

    }
      
    public function ranap_apotek(Request $request) {
        $years = DB::table('penjualan')
            ->select(DB::raw('YEAR(tgl_jual) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $apotek = DB::table('penjualan as p')
        ->join('reg_periksa as r', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
        ->where('r.status_lanjut', '=', 'Ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tgl_jual', $year)
        ->whereMonth('p.tgl_jual', $month)
        ->select(DB::raw('DATE(p.tgl_jual) as tanggal'), DB::raw('COUNT(*) as jumlah_apotek'))
        ->groupBy(DB::raw('DATE(p.tgl_jual)'))
        ->get();

        $three_months = DB::table('penjualan as p')
        ->join('reg_periksa as r', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
        ->select([
            DB::raw('YEAR(p.tgl_jual) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tgl_jual) - 1) / 3) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tgl_jual) BETWEEN 1 AND 3 THEN 'Januari - Maret'
            WHEN MONTH(p.tgl_jual) BETWEEN 4 AND 6 THEN 'April - Juni'
            WHEN MONTH(p.tgl_jual) BETWEEN 7 AND 9 THEN 'Juli - September'
            WHEN MONTH(p.tgl_jual) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_apotek')
        ])
        ->where('r.status_lanjut', '=', 'Ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tgl_jual', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();        
        // dd($three_months);

        $six_months = DB::table('penjualan as p')
        ->join('reg_periksa as r', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
        ->select([
            DB::raw('YEAR(p.tgl_jual) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tgl_jual) - 1) / 6) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tgl_jual) BETWEEN 1 AND 6 THEN 'Januari - Juni'
            WHEN MONTH(p.tgl_jual) BETWEEN 7 AND 12 THEN 'Juli - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_apotek')
        ])
        ->where('r.status_lanjut', '=', 'Ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tgl_jual', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        // dd($six_months);

        $one_years = DB::table('penjualan as p')
        ->join('reg_periksa as r', 'p.no_rkm_medis', '=', 'r.no_rkm_medis')
        ->select([
            DB::raw('YEAR(p.tgl_jual) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tgl_jual) - 1) / 12) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tgl_jual) BETWEEN 1 AND 12 THEN 'Januari - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS jumlah_apotek')
        ])
        ->where('r.status_lanjut', '=', 'Ranap')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tgl_jual', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        // dd($one_years);

        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_apotek];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_apotek];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_apotek];
            });
        } elseif ($request->input('month') ) {
            $query = $apotek->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->jumlah_apotek];
            });
        }

        return view('pages.tech.kunjungan.rawat-inap.dashboard-ranap-apotek', compact('years', 'query'));
    }

    public function ranap_fisioterapi(Request $request) {
        $years = DB::table('reg_periksa')
            ->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');

        $fisioterapi = DB::table('penilaian_fisioterapi as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->where('r.status_lanjut', '=', 'Ralan')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tanggal', $year)
        ->whereMonth('p.tanggal', $month)
        ->select(DB::raw('DATE(p.tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah_fisioterapi'))
        ->groupBy(DB::raw('DATE(p.tanggal)'))
        ->get();

        $three_months = DB::table('penilaian_fisioterapi as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select([
            DB::raw('YEAR(p.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tanggal) - 1) / 3) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tanggal) BETWEEN 1 AND 3 THEN 'Januari - Maret'
            WHEN MONTH(p.tanggal) BETWEEN 4 AND 6 THEN 'April - Juni'
            WHEN MONTH(p.tanggal) BETWEEN 7 AND 9 THEN 'Juli - September'
            WHEN MONTH(p.tanggal) BETWEEN 10 AND 12 THEN 'Oktober - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS  jumlah_fisioterapi')
        ])
        ->where('r.status_lanjut', '=', 'Ralan')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();    
        // dd($three_months);

        $six_months = DB::table('penilaian_fisioterapi as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select([
            DB::raw('YEAR(p.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tanggal) - 1) / 6) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tanggal) BETWEEN 1 AND 6 THEN 'Januari - Juni'
            WHEN MONTH(p.tanggal) BETWEEN 7 AND 12 THEN 'Juli - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS  jumlah_fisioterapi')
        ])
        ->where('r.status_lanjut', '=', 'Ralan')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        // dd($six_months);

        $one_years = DB::table('penilaian_fisioterapi as p')
        ->join('reg_periksa as r', 'p.no_rawat', '=', 'r.no_rawat')
        ->select([
            DB::raw('YEAR(p.tanggal) AS tahun'),
            DB::raw('FLOOR((MONTH(p.tanggal) - 1) / 12) + 1 AS periode'),
            DB::raw("CASE 
            WHEN MONTH(p.tanggal) BETWEEN 1 AND 12 THEN 'Januari - Desember'
            ELSE 'Tidak Valid'
        END AS keterangan_periode"),
            DB::raw('COUNT(*) AS  jumlah_fisioterapi')
        ])
        ->where('r.status_lanjut', '=', 'Ralan')
        ->where('r.kd_poli', '!=', 'IGD01')
        ->where('r.kd_poli', '!=', 'IGDK')
        ->whereYear('p.tanggal', $year)
        ->groupBy('tahun', 'periode', 'keterangan_periode')
        ->get();
        // dd($one_years);

        $query = [];

        if ($request->input('triwulan') ) {
            $query = $three_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_fisioterapi];
            });
        } elseif ($request->input('semester') ) {
            $query = $six_months->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_fisioterapi];
            });
        } elseif ($request->input('tahunan') ) {
            $query = $one_years->mapWithKeys(function ($item) {
                return [$item->keterangan_periode => $item->jumlah_fisioterapi];
            });
        } elseif ($request->input('month') ) {
            $query = $fisioterapi->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->jumlah_fisioterapi];
            });
        }


        return view('pages.tech.kunjungan.rawat-inap.dashboard-ranap-fisioterapi', compact('years', 'query'));
    }

    public function ranap_rad(Request $request) {
        $years = DB::table('periksa_radiologi')
            ->select(DB::raw('YEAR(tgl_periksa) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        // $jns_perawatan_radiologi = DB::table('jns_perawatan_radiologi')
        //     ->select('kd_jenis_prw', 'nm_perawatan')
        //     ->where('kd_jenis_prw', 'like', 'RADU%')
        //     ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        // $rad = $request->input('jns_perawatan_radiologi');
    
        $bar = DB::table('periksa_radiologi as pr')
        ->join('jns_perawatan_radiologi as jpr', 'pr.kd_jenis_prw', '=', 'jpr.kd_jenis_prw')
        ->select(
            // 'pr.tgl_periksa', 
            'jpr.nm_perawatan',
            DB::raw('COUNT(pr.no_rawat) AS jumlah_no_perawat')
        )
        ->where('pr.kd_jenis_prw', 'like', 'RADU%')
        ->whereYear('pr.tgl_periksa', '=', $year)
        ->whereMonth('pr.tgl_periksa', '=', $month)
        ->where('pr.status', 'ranap')
        ->groupBy(
            // 'pr.tgl_periksa', 
            'jpr.nm_perawatan'
        )
        ->orderBy('pr.tgl_periksa')
        ->limit(10)
        ->get();
    
    
        $query = $bar->mapWithKeys(function ($item) {
            return [$item->nm_perawatan => $item-> jumlah_no_perawat];
        });
    
        return view('pages.tech.kunjungan.rawat-inap.dashboard-ranap-rad', compact(
            'query',
            'years',
            // 'jns_perawatan_radiologi'
        ));
    }

}
