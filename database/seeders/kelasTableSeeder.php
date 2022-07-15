<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     DB::table('kelases')->insert([
        'id'=> 500,
        'kelas' => "1a"
    ]);
     DB::table('kelases')->insert([
        'id'=> 501,
        'kelas' => "1b"
    ]);
     DB::table('kelases')->insert([
        'id'=> 502,
        'kelas' => "2a"
    ]);
     DB::table('kelases')->insert([
        'id'=> 503,
        'kelas' => "2b"
    ]);
     DB::table('kelases')->insert([
        'id'=> 504,
        'kelas' => "3a"
    ]);
     DB::table('kelases')->insert([
        'id'=> 505,
        'kelas' => "3b"
    ]);
     DB::table('kelases')->insert([
        'id'=> 506,
        'kelas' => "4a"
    ]);
     DB::table('kelases')->insert([
        'id'=> 507,
        'kelas' => "4b"
    ]);
     DB::table('kelases')->insert([
        'id'=> 508,
        'kelas' => "5a"
    ]);
     DB::table('kelases')->insert([
        'id'=> 509,
        'kelas' => "5b"
    ]);
     DB::table('kelases')->insert([
        'id'=> 510,
        'kelas' => "6a"
    ]);
     DB::table('kelases')->insert([
        'id'=> 511,
        'kelas' => "6b"
    ]);
          DB::table('kelases')->insert([
        'id'=> 512,
        'kelas' => "LULUS"
    ]);
 }
}
