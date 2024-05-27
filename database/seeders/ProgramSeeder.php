<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('program')->insert([
            ['id_program' => '111', 'nama_program' => 'Day Care', 'tipe' => 'pagi', 'harga' => 40000],
            ['id_program' => '112', 'nama_program' => 'Day Care', 'tipe' => 'sore', 'harga' => 40000],
            ['id_program' => '113', 'nama_program' => 'Day Care', 'tipe' => 'full_day', 'harga' => 80000],
            ['id_program' => '121', 'nama_program' => 'Day Care', 'tipe' => 'pagi', 'harga' => 50000],
            ['id_program' => '122', 'nama_program' => 'Day Care', 'tipe' => 'sore', 'harga' => 50000],
            ['id_program' => '123', 'nama_program' => 'Day Care', 'tipe' => 'full_day', 'harga' => 100000],
            ['id_program' => '21', 'nama_program' => 'Grha Wredha Mulya', 'tipe' => 'unit_a', 'harga' => 17500000],
            ['id_program' => '22', 'nama_program' => 'Grha Wredha Mulya', 'tipe' => 'unit_b', 'harga' => 20000000],
        ]);   
    }
}