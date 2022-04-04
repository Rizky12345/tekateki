<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    protected $fillable = ['name','password'];
    use HasApiTokens, HasFactory, Notifiable;
        public function kelase(){
        return $this->belongsTo('App\Models\kelase');
    }
}
