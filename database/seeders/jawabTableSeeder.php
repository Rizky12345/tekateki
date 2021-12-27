<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class jawabTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('jawabans')->insert([
    		'jawaban' => "benda cair yang dapat berubah sesuai tempat",
    		'soal_id' => 500,
            'user_id' => 500
    	]);
    	DB::table('jawabans')->insert([
    		'jawaban' => "berhenti",
    		'soal_id' => 400,
            'user_id' => 500
    	]);
    }
}
