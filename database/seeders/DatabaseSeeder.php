<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(usersTableSeeder::class);
        $this->call(statusTableSeeder::class);
        $this->call(mapelTableSeeder::class);
        $this->call(timeTableSeeder::class);
        $this->call(ujianTableSeeder::class);
        $this->call(ratingTableSeeder::class);
        $this->call(soalsTableSeeder::class);
        $this->call(pilihansTableSeeder::class);
        $this->call(kjawabanTableSeeder::class);
        
    }
}
