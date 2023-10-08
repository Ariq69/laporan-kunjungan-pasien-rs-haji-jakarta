<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'petugas';

    public function jabatan()
        {
            return $this->belongsTo(Jabatan::class, 'kd_jbtn', 'kd_jbtn');
        }
}
