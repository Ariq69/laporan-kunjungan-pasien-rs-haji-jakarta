<?php

namespace App\Http\Controllers\Tech;

use App\Models\Pasien;
use App\Models\KamarPasien;

use Illuminate\Http\Request;
use App\Models\RegistrasiPasien;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PasienController extends Controller
{
    public function __construct()
        {
            $this->middleware('auth',['tech']);
        }

    public function pasien(){

        return view('pages.tech.pasien.dashboard-pasien');
    }

    public function pasien_perbulan(Request $request){
                $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();

        $poliklinik = DB::table('poliklinik')
            ->select('kd_poli', 'nm_poli')
            ->get();

        $year = $request->input('year');
        $month = $request->input('month');
        $poli = $request->input('poliklinik');


        $jumlahData = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->select('reg_periksa.stts_daftar', DB::raw('COUNT(*) as jumlah_data'))
            ->whereYear('reg_periksa.tgl_registrasi', $year)
            ->whereMonth('reg_periksa.tgl_registrasi', $month)
            ->where('poliklinik.nm_poli', $poli)
            ->groupBy('reg_periksa.stts_daftar')
            ->get();

        $query = $jumlahData->mapWithKeys(function ($item){
            return [$item->stts_daftar => $item->jumlah_data];
        });

        return view('pages.tech.pasien.dashboard-pasien-perbulan', compact('years','poliklinik','query'));

    }
    public function pasien_carabayar(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');

        $barchart = $result = DB::table('reg_periksa')
            ->join('penjab as p', 'reg_periksa.kd_pj', '=', 'p.kd_pj')
            ->groupBy('p.kd_kel_pj')
            ->select('p.kd_kel_pj', DB::raw('COUNT(p.kd_pj) as jumlah_kd_pj'))
            ->orderBy('p.kd_kel_pj', 'asc')
            ->get();
        
        $details = DB::table('reg_periksa')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('kel_penjab', 'penjab.kd_kel_pj', '=', 'kel_penjab.kd_kel_pj')
            ->select('poliklinik.nm_poli', 'kel_penjab.kd_kel_pj', DB::raw('COUNT(*) AS jumlah_pasien'))
            ->whereIn('kel_penjab.kd_kel_pj', ["UMUM", "BPJ", "ADM", "PER"])
            ->groupBy('poliklinik.nm_poli', 'kel_penjab.kd_kel_pj')
            ->get()
            ->groupBy('nm_poli');
        // Menghitung total jumlah_kd_pj
        $totalJumlahKdPj = $result->sum('jumlah_kd_pj');

        $barQuery = $result->mapWithKeys(function ($item){
            return [$item->kd_kel_pj => $item->jumlah_kd_pj];
        });

        // Menambahkan total ke dalam array data untuk bar chart
        $barQuery['Total'] = $totalJumlahKdPj;

        return view('pages.tech.pasien.dashboard-pasien-percarabayar', compact(
            'years',
            'barQuery',
            'details'
        ));
    }

    public function pasien_perpoli(Request $request){

        $years = DB::table('reg_periksa')->select(DB::raw('YEAR(tgl_registrasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get();
        
        $year = $request->input('year');
        $month = $request->input('month');

        $bar = DB::table('poliklinik as p')
            ->leftJoin('reg_periksa as r', 'p.kd_poli', '=', 'r.kd_poli')
            ->select('p.nm_poli', DB::raw('COUNT(r.kd_poli) as jumlah_poli'))
            ->whereYear('r.tgl_registrasi', $year)
            ->whereMonth('r.tgl_registrasi', $month)
            ->groupBy('p.nm_poli')
            ->get();



        $query = $bar->mapWithKeys(function ($item){
            return [$item->nm_poli => $item->jumlah_poli];
        
        });

        return view('pages.tech.pasien.dashboard-pasien-perpoli', compact('years','query'));
    }


    public function pasien_baru(){
            
            if (request()->ajax()) {
            $data_pasien = RegistrasiPasien::with('penjab','reg_dokter','poli','namapasien')->where('stts_daftar', 'Baru');

            return Datatables::of($data_pasien)->make(true);
        }

        return view('pages.tech.pasien.dashboard-pasien-baru');
    }
        
    public function informasi_kamar(){

        $jumlah_kamar_afiah = number_format(KamarPasien::where('kd_bangsal', 'AFI')->count());
        $jumlah_kamar_afiso = number_format(KamarPasien::where('kd_bangsal', 'AFISO')->count());
        $jumlah_kamar_ama = number_format(KamarPasien::where('kd_bangsal', 'AMA')->count());
        $jumlah_kamar_amab = number_format(KamarPasien::where('kd_bangsal', 'AMAB')->count());
        $jumlah_kamar_has1 = number_format(KamarPasien::where('kd_bangsal', 'HAS1')->count());
        $jumlah_kamar_has06 = number_format(KamarPasien::where('kd_bangsal', 'HAS06')->count());
        $jumlah_kamar_has07 = number_format(KamarPasien::where('kd_bangsal', 'HAS07')->count());
        $jumlah_kamar_has08 = number_format(KamarPasien::where('kd_bangsal', 'HAS08')->count());
        $jumlah_kamar_syi = number_format(KamarPasien::where('kd_bangsal', 'SYI')->count());
        $jumlah_kamar_syiso = number_format(KamarPasien::where('kd_bangsal', 'SYISO')->count());
        $jumlah_kamar_sak = number_format(KamarPasien::where('kd_bangsal', 'SAK')->count());
        $jumlah_kamar_mul = number_format(KamarPasien::where('kd_bangsal', 'MUL')->count());
        $jumlah_kamar_neo = number_format(KamarPasien::where('kd_bangsal', 'NEO')->count());
        $jumlah_kamar_icu = number_format(KamarPasien::where('kd_bangsal', 'ICU')->count());
        $jumlah_kamar_iccu = number_format(KamarPasien::where('kd_bangsal', 'ICCU')->count());
        $jumlah_kamar_nicu = number_format(KamarPasien::where('kd_bangsal', 'NICU')->count());
        $jumlah_kamar_ist = number_format(KamarPasien::where('kd_bangsal', 'IST')->count());
        $jumlah_kamar_ist01 = number_format(KamarPasien::where('kd_bangsal', 'IST01')->count());
        $jumlah_kamar_ist02 = number_format(KamarPasien::where('kd_bangsal', 'IST02')->count());

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar',[
            'jumlah_kamar_afiah' => $jumlah_kamar_afiah,
            'jumlah_kamar_afiso' => $jumlah_kamar_afiso,
            'jumlah_kamar_ama' => $jumlah_kamar_ama,
            'jumlah_kamar_amab' => $jumlah_kamar_amab,
            'jumlah_kamar_has1' => $jumlah_kamar_has1,
            'jumlah_kamar_has06' => $jumlah_kamar_has06,
            'jumlah_kamar_has07' => $jumlah_kamar_has07,
            'jumlah_kamar_has08' => $jumlah_kamar_has08,
            'jumlah_kamar_syi' => $jumlah_kamar_syi,
            'jumlah_kamar_syiso' => $jumlah_kamar_syiso,
            'jumlah_kamar_sak' => $jumlah_kamar_sak,
            'jumlah_kamar_mul' => $jumlah_kamar_mul,
            'jumlah_kamar_neo' => $jumlah_kamar_neo,
            'jumlah_kamar_icu' => $jumlah_kamar_icu,
            'jumlah_kamar_iccu' => $jumlah_kamar_iccu,
            'jumlah_kamar_nicu' => $jumlah_kamar_nicu,
            'jumlah_kamar_ist' => $jumlah_kamar_ist,
            'jumlah_kamar_ist01' => $jumlah_kamar_ist01,
            'jumlah_kamar_ist02' => $jumlah_kamar_ist02,
        ]);
    }

    public function informasi_kamar_afiah() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'AFI');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_afiah = KamarPasien::where('kd_bangsal', 'AFI')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'AFI')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'AFI')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'AFI')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-afiah', [
            'informasi_kamar_afiah' => $informasi_kamar_afiah,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_afiso() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'AFISO');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_afiso = KamarPasien::where('kd_bangsal', 'AFISO')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'AFISO')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'AFISO')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'AFISO')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-afiso', [
            'informasi_kamar_afiso' => $informasi_kamar_afiso,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_ama() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'AMA');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_ama = KamarPasien::where('kd_bangsal', 'AMA')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'AMA')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'AMA')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'AMA')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-ama', [
            'informasi_kamar_ama' => $informasi_kamar_ama,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_amab() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'AMAB');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_amab = KamarPasien::where('kd_bangsal', 'AMAB')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'AMAB')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'AMAB')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'AMAB')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-amab', [
            'informasi_kamar_amab' => $informasi_kamar_amab,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_has1() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'HAS1');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_has1 = KamarPasien::where('kd_bangsal', 'HAS1')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'HAS1')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'HAS1')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'HAS1')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-has1', [
            'informasi_kamar_has1' => $informasi_kamar_has1,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_has06() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'HAS06');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_has06 = KamarPasien::where('kd_bangsal', 'HAS06')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'HAS06')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'HAS06')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'HAS06')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-has06', [
            'informasi_kamar_has06' => $informasi_kamar_has06,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_has07() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'HAS07');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_has07 = KamarPasien::where('kd_bangsal', 'HAS07')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'HAS07')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'HAS07')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'HAS07')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-has07', [
            'informasi_kamar_has07' => $informasi_kamar_has07,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_has08() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'HAS08');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_has08 = KamarPasien::where('kd_bangsal', 'HAS08')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'HAS08')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'HAS08')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'HAS08')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-has08', [
            'informasi_kamar_has08' => $informasi_kamar_has08,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_syi() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'SYI');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_syi = KamarPasien::where('kd_bangsal', 'SYI')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'SYI')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'SYI')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'SYI')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-syi', [
            'informasi_kamar_syi' => $informasi_kamar_syi,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_syiso() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'SYISO');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_syiso = KamarPasien::where('kd_bangsal', 'SYISO')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'SYISO')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'SYISO')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'SYISO')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-syiso', [
            'informasi_kamar_syiso' => $informasi_kamar_syiso,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_sak() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'SAK');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_sak = KamarPasien::where('kd_bangsal', 'SAK')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'SAK')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'SAK')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'SAK')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-sak', [
            'informasi_kamar_sak' => $informasi_kamar_sak,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_mul() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'MUL');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_mul = KamarPasien::where('kd_bangsal', 'MUL')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'MUL')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'MUL')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'MUL')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-mul', [
            'informasi_kamar_mul' => $informasi_kamar_mul,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_neo() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'NEO');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_neo = KamarPasien::where('kd_bangsal', 'NEO')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'NEO')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'NEO')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'NEO')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-neo', [
            'informasi_kamar_neo' => $informasi_kamar_neo,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_icu() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'ICU');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_icu = KamarPasien::where('kd_bangsal', 'ICU')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'ICU')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'ICU')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'ICU')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-icu', [
            'informasi_kamar_icu' => $informasi_kamar_icu,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_iccu() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'ICCU');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_iccu = KamarPasien::where('kd_bangsal', 'ICCU')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'ICCU')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'ICCU')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'ICCU')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-iccu', [
            'informasi_kamar_iccu' => $informasi_kamar_iccu,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_nicu() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'NICU');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_nicu = KamarPasien::where('kd_bangsal', 'NICU')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'NICU')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'NICU')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'NICU')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-nicu', [
            'informasi_kamar_nicu' => $informasi_kamar_nicu,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }
    
    public function informasi_kamar_ist() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'IST');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_ist = KamarPasien::where('kd_bangsal', 'IST')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'IST')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'IST')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'IST')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-ist', [
            'informasi_kamar_ist' => $informasi_kamar_ist,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_ist01() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'IST01');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_ist01 = KamarPasien::where('kd_bangsal', 'IST01')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'IST01')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'IST01')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'IST01')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-ist01', [
            'informasi_kamar_ist01' => $informasi_kamar_ist01,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

    public function informasi_kamar_ist02() {
        if (request()->ajax()) {
            $data_pasien = KamarPasien::select('*')->where('kd_bangsal', 'IST02');
            return Datatables::of($data_pasien)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        $informasi_kamar_ist02 = KamarPasien::where('kd_bangsal', 'IST02')->count();
        $informasi_kamar_isi = KamarPasien::where('kd_bangsal', 'IST02')->where('status', 'ISI')->count();
        $informasi_kamar_booking = KamarPasien::where('kd_bangsal', 'IST02')->where('status', 'DIBOOKING')->count();
        $informasi_kamar_kosong = KamarPasien::where('kd_bangsal', 'IST02')->where('status', 'KOSONG')->count();

        return view('pages.tech.kunjungan.informasi-kamar.dashboard-informasi-kamar-ist02', [
            'informasi_kamar_ist02' => $informasi_kamar_ist02,
            'informasi_kamar_isi' => $informasi_kamar_isi,
            'informasi_kamar_booking' => $informasi_kamar_booking,
            'informasi_kamar_kosong' => $informasi_kamar_kosong,
        ]);
    }

}
