<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pilihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilihans', function(Blueprint $table){
            $table->id();
            $table->string("pilihan")->nullable();
            $table->string("image")->nullable();
            $table->foreignId("soal_id") ->nullable();
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
        Scema::dropIfExists('pilihans');
    }
}
