<?php

namespace App\Http\Controllers\Tech;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Penjab;
use Yajra\DataTables\Facades\DataTables;

class AsuransiController extends Controller
{
    public function informasi_asuransi() {

        if (request()->ajax()) {
            $data_pasien = Penjab::select('*');
            return Datatables::of($data_pasien)
                ->make(true);
        }

        $jumlah_asuransi_admed = number_format(Penjab::where('kd_kel_pj', 'ADM')->count());
        $jumlah_asuransi_bpj = number_format(Penjab::where('kd_kel_pj', 'BPJ')->count());
        $jumlah_asuransi_per = number_format(Penjab::where('kd_kel_pj', 'PER')->count());
        $jumlah_asuransi_umum = number_format(Penjab::where('kd_kel_pj', 'UMUM')->count());

        return view('pages.tech.asuransi.informasi-asuransi.dashboard-informasi-asuransi',[
            'jumlah_asuransi_admed' => $jumlah_asuransi_admed,
            'jumlah_asuransi_bpj' => $jumlah_asuransi_bpj,
            'jumlah_asuransi_per' => $jumlah_asuransi_per,
            'jumlah_asuransi_umum' => $jumlah_asuransi_umum,
        ]);
    }

}
