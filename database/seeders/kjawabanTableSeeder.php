<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kjawabanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kjawabans')->insert([
            'jawaban' => "benda cair yang dapat berubah sesuai tempat",
            'soal_id' => 500,
            'user_id' => 500,
            'pilihan_id'=> 502
        ]);
        DB::table('kjawabans')->insert([
            'jawaban' => "berhenti",
            'soal_id' => 400,
            'user_id' => 500,
            'pilihan_id'=> 504
        ]);
        DB::table('kjawabans')->insert([
            'jawaban' => "dih",
            'soal_id' => 501,
            'user_id' => 500,
            'pilihan_id'=> 507
        ]);
        DB::table('kjawabans')->insert([
            'jawaban' => "parah",
            'soal_id' => 502,
            'user_id' => 500,
            'pilihan_id'=> 511
        ]);
    }
}
