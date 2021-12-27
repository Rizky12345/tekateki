<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pilihansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('pilihans')->insert([
            'id' => 500,
    		'pilihan' => "batu",
    		'soal_id' => 500
    	]);
    	DB::table('pilihans')->insert([
            'id' => 501,
    		'pilihan' => "kura kura",
    		'soal_id' => 500
    	]);
        DB::table('pilihans')->insert([
            'id' => 502,
            'pilihan' => "benda cair yang dapat berubah sesuai tempat",
            'soal_id' => 500
        ]);
        DB::table('pilihans')->insert([
            'id' => 503,
            'pilihan' => "tamat",
            'soal_id' => 400
        ]);        
        DB::table('pilihans')->insert([
            'id' => 504,
            'pilihan' => "belakhir",
            'soal_id' => 400
        ]);
        DB::table('pilihans')->insert([
            'id' => 505,
            'pilihan' => "berhenti",
            'soal_id' => 400
        ]);
    }
}
