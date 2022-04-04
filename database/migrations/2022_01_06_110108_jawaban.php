<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jawaban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawabans', function(Blueprint $table){
            $table->id();
            $table->text('jawaban');
            $table->foreignId("soal_id");
            $table->foreignId("ujian_id");
            $table->float("point")->nullable();
            $table->foreignId("pilihan_id")->nullable();
            $table->foreignId("user_id");
            $table->foreignId("nilai_id");
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
        Schema::dropIfExists('jawabans');
    }
}
