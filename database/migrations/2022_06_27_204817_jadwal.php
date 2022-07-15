<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('target');
            $table->string('kelas');
            $table->string('tahun_ajaran');
            $table->string('semester')->nullable();
            $table->string('mapel')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('catatan');
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
        Schema::dropIfExists('jadwals');
    }
}
