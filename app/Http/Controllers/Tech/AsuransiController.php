<?php

namespace App\Http\Controllers\Tech;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Penjab;
use Yajra\DataTables\Facades\DataTables;

class AsuransiController extends Controller
{
    public function informasi_asuransi() {

        $jumlah_asuransi_admed = Penjab::whereIn('kd_pj', [
            'A01',
            'A02',
            'A03',
            'A04',
            'A05',
            ])->count();

        return view('pages.tech.asuransi.informasi-asuransi.dashboard-informasi-asuransi', [
            'jumlah_asuransi_admed' => $jumlah_asuransi_admed,
        ]);
    }

    public function informasi_asuransi_admed() {

        if (request()->ajax()) {
            $data_asuransi = Penjab::whereIn('kd_pj', [
            'A01',
            'A02',
            'A03',
            'A04',
            'A05',
            ]);
            return Datatables::of($data_asuransi)
                ->editColumn('trf_kamar', function ($data) {
                    return 'Rp ' . number_format($data->trf_kamar, 0, ',', '.');
                })
                ->make(true);
        }

        return view('pages.tech.asuransi.informasi-asuransi.dashboard-informasi-asuransi-admed');
    }

}
