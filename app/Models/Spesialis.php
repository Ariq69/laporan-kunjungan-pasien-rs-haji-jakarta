<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesialis extends Model
{
    use HasFactory;

    protected $table = 'spesialis';
    
    public $timestamps = false;

    public function RelationToDokter (){
        return $this->belongsTo('App\Models\Dokter', 'kd_sps');
    }
}

