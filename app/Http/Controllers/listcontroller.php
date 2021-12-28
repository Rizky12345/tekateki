<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Rating;
use Illuminate\Support\Collection;

class listcontroller extends Controller
{
  public function index(){
   $list = Ujian::orderBy('id','desc')->get();
   $a = Rating::all();
   $ratingArr = $a->pluck('ujian_id');
   return view('after.list',[
      'lists'=> $list,
      'ratings' => $a,
      'ratingArr' => $ratingArr,
   ]);
}
}
