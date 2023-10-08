<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiPasien extends Model
{
    use HasFactory;

    protected $table = 'reg_periksa';

    public function penjab()
        {
            return $this->belongsTo(Penjab::class, 'kd_pj', 'kd_pj');
        }

    public function reg_dokter()
        {
            return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
        }
    
    public function poli()
        {
            return $this->belongsTo(Poliklinik::class, 'kd_poli', 'kd_poli');
        }
}
