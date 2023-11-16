<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    public function ruang()
    {
        return $this->belongsTo(InventarisRuang::class, 'id_ruang', 'id_ruang');
    }

    public function barang()
    {
        return $this->belongsTo(InventarisBarang::class, 'kode_barang', 'kode_barang');
    }

    public function produsen()
    {
        return $this->belongsTo(InventarisProdusen ::class, 'kode_produsen', 'nama_produsen');
    }

    public function merk()
    {
        return $this->belongsTo(InventarisMerk ::class, 'id_merk', 'nama_merk');
    }

    public function kategori()
    {
        return $this->belongsTo(InventarisKategori::class, 'id_kategori', 'nama_kategori');
    }

    public function jenis()
    {
        return $this->belongsTo(InventarisJenis ::class, 'id_Jenis', 'nama_jenis');
    }
}
