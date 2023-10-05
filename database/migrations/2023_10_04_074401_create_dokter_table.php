<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Dokter;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->string('kd_dokter');
            $table->string('nm_dokter');
            $table->enum('jk',['L','P']);
            $table->string('tmp_lahir');
            $table->date('tgl_lahir');
            $table->enum('gol_drh',['A','B','O','AB']);
            $table->string('agama');
            $table->string('almt_tgl');
            $table->string('no_telp');
            $table->enum('stts_nikah',['BELUM MENIKAH', 'MENIKAH', 'JANDA', 'DUDHA']);
            $table->char('kd_sps');
            $table->string('alumni');
            $table->string('no_ijn_praktek');
            $table->enum('status',['0','1']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
