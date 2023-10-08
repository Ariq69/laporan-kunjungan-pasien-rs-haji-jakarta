<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';

    public function penjab()
        {
            return $this->belongsTo(Penjab::class, 'kd_pj', 'kd_pj');
        }
    
        public function suku()
        {
            return $this->belongsTo(SukuBangsa::class, 'suku_bangsa', 'id');
        }

        public function bahasa()
        {
            return $this->belongsTo(BahasaPasien::class, 'bahasa_pasien', 'id');
        }

        public function cacatfisik()
        {
            return $this->belongsTo(CacatFisik::class, 'cacat_fisik', 'id');
        }
}
