<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriksaRadiologi extends Model
{
    use HasFactory;

    protected $table = 'periksa_radiologi';

    public function jenis_perawatan_radiologi_ralan()
    {
        return $this->belongsTo(JnsPerawatanRadiologi::class, 'kd_jenis_prw','nm_perawatan');
    }

    public function jenis_perawatan_radiologi_ranap()
    {
        return $this->belongsTo(JnsPerawatanRadiologi::class, 'kd_jenis_prw','nm_perawatan');
    }

    public function regis_pasien()
    {
        return $this->belongsTo(RegistrasiPasien::class, 'no_rawat', 'no_rkm_medis');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rawat', 'no_rkm_medis');
    }

}