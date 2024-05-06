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
            ['id_program' => '11', 'nama_program' => 'Day Care', 'tipe' => 'weekday','harga' => 40000],
            ['id_program' => '12', 'nama_program' => 'Day Care', 'tipe' => 'weekend', 'harga' => 50000],
            ['id_program' => '21', 'nama_program' => 'Grha Wredha Mulya', 'tipe' => 'unit_a', 'harga' => 17500000],
            ['id_program' => '22', 'nama_program' => 'Grha Wredha Mulya', 'tipe' => 'unit_b', 'harga' => 20000000],
        ]);    
    }
}