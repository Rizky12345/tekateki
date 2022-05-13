<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kjawaban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kjawabans', function(Blueprint $table){
            $table->id();
            $table->string('jawaban')->nullable();
            $table->string('image')->nullable();
            $table->foreignId("soal_id");
            $table->foreignId("user_id");
            $table->foreignId("pilihan_id");
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
        Schema::dropIfExists('kjawabans');
    }
}
