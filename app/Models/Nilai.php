<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
        public function ujian(){
        return $this->belongsTo('App\Models\Ujian');
    }
}
