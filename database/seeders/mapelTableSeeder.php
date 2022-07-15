<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class mapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mapels')->insert([
            'id' => 500,
            'mapel' => "Matematika"
        ]);
        DB::table('mapels')->insert([
            'id' => 400,
            'mapel' => "Pendidikan Al Islam"
        ]);
        DB::table('mapels')->insert([
            'id' => 502,
            'mapel' => "Bahasa Indonesia"
        ]);
        DB::table('mapels')->insert([
            'id' => 501,
            'mapel' => "Bahasa Inggris"
        ]);
        DB::table('mapels')->insert([
            'id' => 503,
            'mapel' => "Bahasa Sunda"
        ]);
        DB::table('mapels')->insert([
            'id' => 504,
            'mapel' => "PJOK"
        ]);
        DB::table('mapels')->insert([
            'id' => 505,
            'mapel' => "PLH"
        ]);
        DB::table('mapels')->insert([
            'id' => 506,
            'mapel' => "TIK"
        ]);
    }
}
