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
            'email' => "kakujaa0015@gmail.com",
            'password' => Hash::make('another0015'),
            'level' => "admin"
        ]);
        DB::table('users')->insert([
            'id'=>501,
            'name' => "qiqi",
            'email' => "qiqi@gmail.com",
            'password' => Hash::make('another0015'),
            'level' => "super admin"
        ]);
    }
}
