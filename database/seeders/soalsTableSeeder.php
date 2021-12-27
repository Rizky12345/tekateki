<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class soalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('soals')->insert([
            'id' => 500,
            'soal' => "apa itu air?",
            'ujian_id'=> 500
        ]);
        DB::table('soals')->insert([
            'id' => 400,
            'soal' => "budi ... dijalan anggrek",
            'ujian_id'=> 500
        ]);
    }
}
