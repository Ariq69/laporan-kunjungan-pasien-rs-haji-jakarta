<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->string('kd_dokter');
            $table->enum('hari_kerja',['SENIN','SELASA','RABU','KAMIS','JUMAT']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('kd_poli');
            $table->integer('kuota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
