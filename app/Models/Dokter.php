<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
            'kd_dokter',
            'nm_dokter', 
            'jk',
            'tmp_lahir',
            'tgl_lahir',
            'gol_drh',
            'agama',
            'almt_tgl',
            'no_telp',
            'stts_nikah',
            'kd_sps',
            'alumni',
            'no_ijn_praktek',
            'status',
    ];

    public $timestamps = false;

    protected $table = 'dokter';
}
