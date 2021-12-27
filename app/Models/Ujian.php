<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;
    public function mapel(){
        return $this->belongsTo('App\Models\Mapel');
    }
    public function statuse(){
        return $this->belongsTo('App\Models\Statuse');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
