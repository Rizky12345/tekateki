<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'=>500,
            'name' => "rizky",
            'kelase_id' => 510,
            'user_id' => 1930511035,
            'password' => Hash::make('qweqwe'),
            'image' => NULL,
            'level' => "super admin"
        ]);
        DB::table('users')->insert([
            'id'=>501,
            'name' => "qiqi",
            'kelase_id' => 510,
            'user_id' => 1930511036,
            'password' => Hash::make('qweqwe'),
            'image' => NULL,
            'level' => "admin"
        ]);
        DB::table('users')->insert([
            'id'=>502,
            'name' => "waaw",
            'kelase_id' => 510,
            'user_id' => 1930511037,
            'password' => Hash::make('qweqwe'),
            'image' => NULL,
            'level' => "user"
        ]);
    }
}
