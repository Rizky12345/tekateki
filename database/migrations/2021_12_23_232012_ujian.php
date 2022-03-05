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
            $table->string('code');
            $table->string('repeat');
            $table->string('status');
            $table->integer('kkm');
            $table->text('keterangan')->nullable();
            $table->foreignId('mapel_id');
            $table->foreignId('kelase_id');
            $table->foreignId('user_id');
            $table->foreignId('time_id');
            $table->timestamps();
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
