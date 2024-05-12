<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            ['ktp' => '3307091204010006', 
            'nama' => 'sidqi', 
            'email' => 'rageave26@gmail.com', 
            'password' =>Hash::make('123456'),
            'no_hp' => '085161052931'],
            [
            'ktp' => '3307091204010023', 
            'nama' => 'faris', 
            'email' => 'farisjeh425@gmail.com', 
            'password' =>Hash::make('asdasd'),
            'no_hp' => '085161052121' 
            ],
       ]);  
    }
}