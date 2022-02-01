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
            'ujian_id'=> 500,
            'type'=> "pilihan"
        ]);
        DB::table('soals')->insert([
            'id' => 400,
            'soal' => "budi ... dijalan anggrek",
            'ujian_id'=> 500,
            'type'=> "pilihan"
        ]);
        DB::table('soals')->insert([
            'id' => 401,
            'soal' => "apa apaan",
            'ujian_id'=> 500,
            'type'=> "essay"
        ]);
        DB::table('soals')->insert([
            'id' => 501,
            'soal' => "lah?",
            'ujian_id'=> 400,
            'type'=> "pilihan"
        ]);
        DB::table('soals')->insert([
            'id' => 502,
            'soal' => "apa yang kau lakukan?",
            'ujian_id'=> 400,
            'type'=> "pilihan"
        ]);
    }
}
