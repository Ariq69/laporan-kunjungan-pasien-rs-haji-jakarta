<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPerawatanRadiologi extends Model
{
    use HasFactory;

    protected $table = 'jns_perawatan_radiologi';
    protected $fillable = [
        'kd_jenis_prw',
        'nm_perawatan',
    ];
}