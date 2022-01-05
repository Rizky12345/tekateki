<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\soal;
use App\Models\pilihan;
use App\Models\Jawaban;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Support\Facades\DB;

class acceptcontroller extends Controller
{
	public function index(Request $request){
		$a = Ujian::where('code', '=', $request->code)->firstOrFail();
		$find_ujian = Ujian::find($a->id);
		return view('after/accept',[
			"title" => "Accept",
			"ujian" => $find_ujian
		]);
	}
	public function redirect_choice(Request $request){
		$request->session()->put('accept', Str::random(30));
		$request->session()->put('code', $request->code);
		// $a = Ujian::where('code', '=', $request->code)->firstOrFail();

		// $soal = Soal::where('ujian_id', '=', $a->id)->firstOrFail();
		return redirect('user/accept/'.$request->session()->get('accept'));
	}
	public function choice(Request $request){
		$id = Ujian::where('code', '=', session()->get('code'))->firstOrFail();
		$soals = Soal::where('ujian_id', '=', $id->id)->paginate(1);
		$soalss = Soal::where('ujian_id', '=', $id->id)->get();
		foreach($soals as $soal){
			$pilihan = Pilihan::where('Soal_id', '=', $soal->id)->get();
			$jawaban = DB::table('Jawabans')
			->where('user_id', Auth::user()->id)
			->where('soal_id', $soal->id)->get();
		}
		
		$pilih = Pilihan::where('soal_id');
		return view('after/pilihan',[
			"title" => "Soal",
			"soals"=>$soals,
			"soalss" => $soalss,
			"jawabans" => $jawaban,
			"pilihans" => $pilihan
		]);
	}
	public function essay(){
		return view("after/essay",[
			"title"=>"essay",

		]);
	}
	public function store(Request $request, $random){
		$jawabans = DB::table('Jawabans')->where('user_id', Auth::user()->id)->where('soal_id', $request['id'])->get();

		if($jawabans->isEmpty()){
			$save = new Jawaban;
			$save->jawaban = $request['jawaban'];
			$save->soal_id = $request['id'];
			$save->user_id = Auth::user()->id;
			$save->save();
			return $save->jawaban;
		}else{
			$jawaban = DB::table('Jawabans')
			->where('user_id', Auth::user()->id)
			->where('soal_id', $request['id'])->update([
				'jawaban' => $request['jawaban']
			]);
			return $jawaban;
		}
	}
	public function destroy(Request $request){
		$request->session()->forget("accept");

		return redirect('user');
	}

}
