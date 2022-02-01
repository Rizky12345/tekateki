<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sadmincontroller extends Controller
{
    public function index(){
        return view('sadmin/index');
    }
}
