<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sewas')->insert(
            [
            'nama_penyewa' => 'Liant',
            'jam_mulai' => Carbon::createFromFormat('H:i', '19:00')->format('H:i:s'),
            'jam_selesai' => Carbon::createFromFormat('H:i', '21:00')->format('H:i:s'),
            'tanggal' => Carbon::parse('2023-9-8'),
            'biayatotal' => '200000',
            'lapangan_id' => '1',
            'acc' => '0'
            ]

    );
    }
}
