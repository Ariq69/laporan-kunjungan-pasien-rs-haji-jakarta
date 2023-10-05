<?php

namespace Database\Seeders;

use App\Models\JadwalDokter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class JadwalDokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwal_dokter = [
            [
            'kd_dokter' => 'dr.ahmad',
            'hari_kerja' => 'SENIN', 
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'kd_poli' => 'RS056',
            'kuota' => '30',
            ],
            [
            'kd_dokter' => 'dr.ariq',
            'hari_kerja' => 'KAMIS', 
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'kd_poli' => 'RF089',
            'kuota' => '30',
            ],
            [
            'kd_dokter' => 'dr.anggia',
            'hari_kerja' => 'SELASA', 
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'kd_poli' => 'RJ012',
            'kuota' => '30',
            ],
            [
            'kd_dokter' => 'dr.raihan',
            'hari_kerja' => 'JUMAT', 
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'kd_poli' => 'RJ007',
            'kuota' => '30',
            ],
        ];

        foreach($jadwal_dokter as $key => $var){
            JadwalDokter::create($var);
        }
    }
}
