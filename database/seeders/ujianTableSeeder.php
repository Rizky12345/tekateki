<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'mapel_id' => 500,
            'statuses_id' => 500,
            'user_id' => 500
        ]);
        DB::table('ujians')->insert([
            'id'=> 400,
            'judul' => "bangun datar",
            'kelas' => "4B",
            'mapel_id' => 400,
            'statuses_id' => 400,
            'user_id' => 500
        ]);
    }
}
