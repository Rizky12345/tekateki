<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ujian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujians', function(Blueprint $table){
            $table->id();
            $table->string('judul');
            $table->string('kelas');
            $table->foreignId('mapel_id');
            $table->foreignId('statuses_id');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujians');
    }
}
