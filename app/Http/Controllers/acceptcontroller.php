<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jawab;
use App\Models\soal;
use App\Models\pilihan;

class acceptcontroller extends Controller
{
	public function index(){
		return view('after/accept',[
			"title" => "Accept",
			"link" => "../../"
		]);
	}
	public function choice(pilihan $pilihan){
		dd($pilihan->all());
		return view('after/pilihan',[
			"title" => "Soal",
			"link" => "../../../",
			"pilihan"=>$pilihan->soals
		]);
	}
	public function essay(){
		return view("after/essay",[
			"title"=>"essay",
			"link"=>"../../../../"

		]);
	}
	public function store(Request $request){
		$save = new jawab;
		$save->jawaban = $request['jawaban'];
		$save->save();
		return $save->jawaban;
	}
}
