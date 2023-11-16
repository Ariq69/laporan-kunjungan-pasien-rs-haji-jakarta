<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeslingPemakaianAirPdam extends Model
{
    protected $table = 'kesling_pemakaian_air_pdam';
    protected $fillable = ['tanggal', 'jumlahharian'];
    // protected $table = 'kesling_pemakaian_air_pdam';
    // protected $primaryKey = 'nip'; // Jika `nip` adalah primary key
    // public $timestamps = false; // Jika tabel tidak memiliki kolom created_at dan updated_at

    // // Tambahkan atribut yang dapat diisi massal jika diperlukan
    // protected $fillable = ['tanggal', 'meteran', 'jumlahharian', 'keterangan'];
}

