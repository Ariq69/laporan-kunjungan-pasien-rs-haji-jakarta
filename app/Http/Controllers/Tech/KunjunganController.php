<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrasiPasien;

class KunjunganController extends Controller
{
    public function totalKunjungan(Request $request) {
        $kunjunganData = RegistrasiPasien::where('no_reg', $request->noReg)
            ->when($request->from, function ($query) use ($request) {
                $query->whereDate('tgl_registrasi', '>=', $request->from);
            })
            ->when($request->to, function ($query) use ($request) {
                $query->whereDate('tgl_registrasi', '<=', $request->to);
            })
            ->sum('stts_daftar');
    
        return response()->json(['kunjunganData' => $kunjunganData]);
    }    
}
