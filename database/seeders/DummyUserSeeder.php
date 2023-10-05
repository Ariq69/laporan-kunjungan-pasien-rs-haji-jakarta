<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
            'name' => 'tech',
            'email' => 'tech@example.com',
            'password' => bcrypt('123'),
            'roles' => 'tech',
            ],
            [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123'),
            'roles' => 'admin',
            ],
            [
            'name' => 'dokter',
            'email' => 'dokter@example.com',
            'password' => bcrypt('123'),
            'roles' => 'dokter',
            ],
            [
            'name' => 'perawat',
            'email' => 'perawat@example.com',
            'password' => bcrypt('123'),
            'roles' => 'perawat',
            ],
            [
            'name' => 'pegawai',
            'email' => 'pegawai@example.com',
            'password' => bcrypt('123'),
            'roles' => 'pegawai',
            ],
            [
            'name' => 'direksi',
            'email' => 'direksi@example.com',
            'password' => bcrypt('123'),
            'roles' => 'direksi',
            ],
        ];

        foreach($user as $key => $var){
            User::create($var);
        }
    }
}
