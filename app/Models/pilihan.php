<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pilihan extends Model
{
    use HasFactory;

    public function soals(){
    	return $this->belongsTo(soal::class);
    }
}
