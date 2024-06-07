<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LapanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lapangans')->insert([
            [
            'nama' => 'WAR STADIUM',
            'alamat' => 'Komplek Telkom Surabaya',
            'deskripsi' => 'Merupakan lapangan yang mantap, cocok digunakan untuk bermain badminton',
            'biayasewa' => '100000',
            'url_foto' => 'https://i.pinimg.com/originals/67/af/67/67af678a6236d40a728b5977ed42bbf3.jpg'
            ],
            [
                'nama' => 'Balbalan Club',
                'alamat' => 'Jl. Semanggi No. 1, Surabaya',
                'deskripsi' => 'Merupakan lapangan yang mantap, cocok digunakan untuk bermain futsal',
                'biayasewa' => '100000',
                'url_foto' => 'https://i.pinimg.com/originals/ba/9e/cd/ba9ecdbd97180d710a5449aefecfc23c.jpg'
            ],
            [
                'nama' => 'Volyoye Club',
                'alamat' => 'Jl. Coklay No. 1, Surabaya',
                'deskripsi' => 'Merupakan lapangan yang mantap, cocok digunakan untuk bermain voly',
                'biayasewa' => '100000',
                'url_foto' => 'https://i.pinimg.com/originals/30/14/55/301455e861155feb511bdeb0d9f3246f.jpg'
            ]
        ]
    );
    }
}
