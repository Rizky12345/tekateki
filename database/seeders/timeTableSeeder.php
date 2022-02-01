<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class timeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('times')->insert([
            'id' => 500,
            'date_time' => "2022-01-13 14:01:58",
            'time' => 90
        ]);
        DB::table('times')->insert([
            'id' => 400,
            'time' => 90
        ]);
    }
}
