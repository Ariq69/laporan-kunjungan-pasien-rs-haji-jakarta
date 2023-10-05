<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;

    protected $fillable = [
            'kd_dokter',
            'hari_kerja', 
            'jam_mulai',
            'jam_selesai',
            'kd_poli',
            'kuota',
    ];

    public $timestamps = false;

    protected $table = 'jadwal';
}

