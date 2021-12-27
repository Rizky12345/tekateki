<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class soal extends Model
{
    use HasFactory;
        protected $fillable = [
        'id_soal',
        'soal',
        'jawaban',
    ];
	public function pilihan(){
		return $this->belongsTo(pilihan::class);
	}
}
