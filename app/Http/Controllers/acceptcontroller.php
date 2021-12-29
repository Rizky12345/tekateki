<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jawab;
use App\Models\soal;
use App\Models\pilihan;
use Illuminate\Support\Str;

class acceptcontroller extends Controller
{
	public function index(){
		return view('after/accept',[
			"title" => "Accept",
			"link" => "../../"
		]);
	}
	public function redirect_choice(Request $request){
		$request->session()->put('accept', Str::random(30));

		return redirect('user/accept/'.$request->session()->get("accept"));
	}
	public function choice(pilihan $pilihan){
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
	public function destroy(Request $request){
		$request->session()->forget("accept");

		return redirect('user/list');
	}
}
