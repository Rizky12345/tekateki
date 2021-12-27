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
    		'mapel' => "SKI"
    	]);
    }
}
