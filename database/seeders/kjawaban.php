<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class kjawaban extends Seeder
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
            'user_id' => 500
        ]);
        DB::table('kjawabans')->insert([
            'jawaban' => "berhenti",
            'soal_id' => 400,
            'user_id' => 500
        ]);
    }
}
