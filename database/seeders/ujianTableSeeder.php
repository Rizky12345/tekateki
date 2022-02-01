<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ujianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ujians')->insert([
            'id'=> 500,
            'judul' => "matrix",
            'kelas' => "5A",
            'code' => Str::random(7),
            'repeat' => "no",
            'mapel_id' => 500,
            'statuses_id' => 500,
            'user_id' => 500,
            'time_id' => 500
        ]);
        DB::table('ujians')->insert([
            'id'=> 400,
            'judul' => "bangun datar",
            'kelas' => "4B",
            'code' => Str::random(7),
            'repeat' => "yes",
            'mapel_id' => 400,
            'statuses_id' => 400,
            'user_id' => 500,
            'time_id' => 400
        ]);
        
    }
}
