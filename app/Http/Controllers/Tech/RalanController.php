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
use App\Models\Spesialis;

class RalanController extends Controller
{
    public function ralan_hemodialisa(Request $request){
        
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
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month)
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

        return view('pages.tech.kunjungan.dashboard-ralan-hemodialisa',compact('years','query'));

    }

    public function ralan_lab(Request $request) {
        $years = DB::table('permintaan_lab')
            ->select(DB::raw('YEAR(tgl_permintaan) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        $labType = $request->input('lab_type'); // Get the selected lab type from the form
        
        $permintaan = DB::table('permintaan_lab')
            ->select(DB::raw('DATE(tgl_permintaan) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_permintaan', $year)
            ->whereMonth('tgl_permintaan', $month)
            ->where('status', 'ralan')
            ->groupBy(DB::raw('CAST(tgl_permintaan AS DATE)'))
            ->orderBy('tanggal')
            ->get();
        
        $pemeriksaan = DB::table('periksa_lab')
            ->select(DB::raw('DATE(tgl_periksa) as tanggal'), DB::raw('COUNT(*) as total_kunjunganlabranap'))
            ->whereYear('tgl_periksa', $year)
            ->whereMonth('tgl_periksa', $month)
            ->where('status', 'ralan')
            ->groupBy(DB::raw('CAST(tgl_periksa AS DATE)'))
            ->orderBy('tanggal')
            ->get();

        $query = [];
    
        if ($labType === 'permintaan') {
            $query = $permintaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        } elseif ($labType === 'pemeriksaan') {
            $query = $pemeriksaan->mapWithKeys(function ($item) {
                return [$item->tanggal => $item->total_kunjunganlabranap];
            });
        }
        //dd($query);
        return view('pages.tech.kunjungan.dashboard-ralan-lab', compact('years', 'query'));
    }

    public function radiologi_ralan(){
        return view('pages.tech.kunjungan.radiologiralan.dashboard-radiologi-ralan');
    }

    public function jenis_perawatan_radiologi_ralan(Request $request) {
        $years = DB::table('periksa_radiologi')
            ->select(DB::raw('YEAR(tgl_periksa) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        $jns_perawatan_radiologi = DB::table('jns_perawatan_radiologi')
            ->select('kd_jenis_prw', 'nm_perawatan')
            ->where('kd_jenis_prw', 'like', 'RADU%')
            ->get();
    
        $year = $request->input('year');
        $month = $request->input('month');
        $rad = $request->input('jns_perawatan_radiologi');
    
        $bar = DB::table('periksa_radiologi as pr')
        ->join('jns_perawatan_radiologi as jpr', 'pr.kd_jenis_prw', '=', 'jpr.kd_jenis_prw')
        ->select('pr.tgl_periksa', 'jpr.nm_perawatan', DB::raw('COUNT(pr.no_rawat) AS jumlah_no_perawat'))
        ->where('jpr.kd_jenis_prw', 'like', 'RADU%')
        // ->whereYear('pr.tgl_periksa', '=', 2023)
        // ->whereMonth('pr.tgl_periksa', '=', 8)
        // ->where('jpr.nm_perawatan', 'Panoramic') 
        ->whereYear('pr.tgl_periksa', '=',$year)
        ->whereMonth('pr.tgl_periksa', '=', $month)
        ->where('jpr.nm_perawatan', $rad) 
        ->where('pr.status', 'ralan')
        ->groupBy('pr.tgl_periksa', 'jpr.nm_perawatan')
        ->orderBy('pr.tgl_periksa')
        ->orderBy('jpr.nm_perawatan')
        ->get();
           
        $query = $bar->mapWithKeys(function ($item) {
            return [$item->tgl_periksa => $item-> jumlah_no_perawat];
        });
    
        return view('pages.tech.kunjungan.radiologiralan.dashboard-pemeriksaan-radiologi-ralan', compact(
            'query',
            'years',
            'jns_perawatan_radiologi'
        ));
    }
//     public function dokter_radiologi_ralan(Request $request) {
        
//             $years = DB::table('periksa_radiologi')
//                 ->select(DB::raw('YEAR(tgl_periksa) as year'))
//                 ->groupBy('year')
//                 ->orderBy('year', 'DESC')
//                 ->get();
        
//             $spesialis = DB::table('spesialis')
//                 ->select('kd_sps', 'nm_sps')
//                 ->get();
        
           
//             $dokter = DB::table('dokter')
//                 ->select('kd_dokter', 'nm_dokter')
//                 ->get();
        
//             $year = $request->input('year');
//             $month = $request->input('month');
//             $sps = $request->input('spesialis'); // Pastikan nama input sesuai dengan formulir Anda
//             $r = $request->input('dokter'); // Pastikan nama input sesuai dengan formulir Anda
        
//             $bar = DB::table('periksa_radiologi as pr')
//     ->select(
//         'pr.tgl_periksa',
//         'd.nm_dokter',
//         's.nm_sps',
//         DB::raw('COUNT(pr.no_rawat) as jumlah_no_perawat')
//     )
//     ->join('dokter as d', 'pr.dokter_perujuk', '=', 'd.kd_dokter')
//     ->join('spesialis as s', 'd.kd_sps', '=', 's.kd_sps')
// ->whereYear('pr.tgl_periksa', '=', $year)
//                 ->whereMonth('pr.tgl_periksa', '=', $month)
//                 ->where('s.nm_sps', '=', $sps)
//                 ->where('d.nm_dokter', '=', $r)
//     ->groupBy('pr.tgl_periksa', 'd.nm_dokter', 's.nm_sps')
//     ->orderBy('d.nm_dokter')
//     ->orderBy('pr.tgl_periksa')
//     ->orderBy('s.nm_sps')
//     ->get();

//             $query = $bar->mapWithKeys(function ($item) {
//                 return [$item->tgl_periksa => $item->jumlah_no_perawat];
//             });
        
//             return view('pages.tech.kunjungan.radiologiralan.dashboard-dokter-radiologi-ralan', compact(
//                 'query',
//                 'years',
//                 'spesialis',
//                 'dokter'
//             ));
//         }

        public function dokter_radiologi_ralan(Request $request) {
        
        $years = DB::table('periksa_radiologi')
        ->select(DB::raw('YEAR(tgl_periksa) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

        // $dokter = DB::table('dokter')
        //     ->select('kd_dokter', 'nm_dokter')
        //     ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        //$r = $request->input('dokter');

        $bar = DB::table('periksa_radiologi AS pr')
        ->join('dokter AS d', 'pr.kd_dokter', '=', 'd.kd_dokter')
        ->join('spesialis AS s', 'd.kd_sps', '=', 's.kd_sps')
        ->select(
            //'pr.tgl_periksa',
            'd.nm_dokter',
             DB::raw('COUNT(pr.no_rawat) AS jumlah_no_perawat'))
        ->whereMonth('pr.tgl_periksa', '=', 8)
        ->whereYear('pr.tgl_periksa', '=', 2023)
        //->where('d.nm_dokter', $r) // Menggunakan where tanpa operator '=', karena kita hanya membandingkan nilai
        ->where('pr.status', 'ralan')
        ->groupBy(
            //'pr.tgl_periksa', 
            'd.nm_dokter')
        ->orderBy('d.nm_dokter')
        //->orderBy('pr.tgl_periksa')
        ->get();
        // dd($bar);
        
            $query = $bar->mapWithKeys(function ($item) {
                return [$item->nm_dokter => $item->jumlah_no_perawat];
            });
        
            return view('pages.tech.kunjungan.radiologiralan.dashboard-dokter-radiologi-ralan', compact(
                'query',
                'years',
                //'dokter'
            ));
        }

        public function dokter_perujuk_ralan(Request $request) {
        
        $years = DB::table('periksa_radiologi')
        ->select(DB::raw('YEAR(tgl_periksa) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

        $spesialis = DB::table('spesialis')
        ->select('kd_sps', 'nm_sps')
        ->get();

        // Mendapatkan dokter berdasarkan spesialisasi yang dipilih
        $selectedSpesialis = $request->input('selected_spesialis');
        $dokter = DB::table('dokter')
            ->select('kd_dokter', 'nm_dokter')
            ->where('kd_sps', $selectedSpesialis)
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        $selectedDokter = $request->input('selected_dokter');

        $bar = DB::table('periksa_radiologi as pr')
            ->select(
                DB::raw('DATE(pr.tgl_periksa) as tgl_periksa'),
                'd.nm_dokter',
                's.nm_sps',
                DB::raw('COUNT(pr.no_rawat) as jumlah_no_perawat')
            )
            ->join('dokter as d', 'pr.dokter_perujuk', '=', 'd.kd_dokter')
            ->join('spesialis as s', 'd.kd_sps', '=', 's.kd_sps')
            ->whereYear('pr.tgl_periksa', '=', $year)
            ->whereMonth('pr.tgl_periksa', '=', $month)
            ->where('pr.status', 'ralan')
            ->when($selectedSpesialis, function ($query) use ($selectedSpesialis) {
                return $query->where('s.kd_sps', $selectedSpesialis);
            })
            ->when($selectedDokter, function ($query) use ($selectedDokter) {
                return $query->where('d.kd_dokter', $selectedDokter);
            })
            ->groupBy(DB::raw('DATE(pr.tgl_periksa)'), 'd.nm_dokter', 's.nm_sps')
            ->orderBy('d.nm_dokter')
            ->orderBy(DB::raw('DATE(pr.tgl_periksa)'))
            ->orderBy('s.nm_sps')
            ->get();
                
                    $query = $bar->mapWithKeys(function ($item) {
                        return [$item->tgl_periksa => $item->jumlah_no_perawat];
                    });
                
                    return view('pages.tech.kunjungan.radiologiralan.dashboard-dokter-perujuk-ralan', compact(
                        'query',
                        'years',
                        'spesialis',
                        'dokter'
                    ));
     }
        
}
