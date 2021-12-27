<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class statusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('statuses')->insert([
    		'id'=> 500,
    		'status' => "enable"
    	]);
    	DB::table('statuses')->insert([
    		'id'=> 400,
    		'status' => "disable"
    	]);
    	DB::table('statuses')->insert([
    		'id'=> 300,
    		'status' => "lock"
    	]);
    }
}
