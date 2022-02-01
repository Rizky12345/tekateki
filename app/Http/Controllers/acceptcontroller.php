<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\pilihan;
use App\Models\Jawaban;
use App\Models\Kjawaban;
use App\Models\Nilai;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class acceptcontroller extends Controller
{
	public function index(Request $request){
		$a = Ujian::where('code', '=', $request->code)->firstOrFail();
		$find_ujian = Ujian::find($a->id);
		$nilai = Nilai::where('ujian_id', '=', $a->id)->where("user_id","=", Auth::user()->id)->get();
		$time = Carbon::now('Asia/Jakarta');
		return view('after/accept',[
			"title" => "Accept",
			"ujian" => $find_ujian,
			"time" => $time->toDateTimeString(),
			"nilai" => $nilai
		]);
	}
	public function redirect_choice(Request $request){
		$request->session()->put('accept', Str::random(30));
		$request->session()->put('code', $request->code);
		$ids = Ujian::where('code', '=', session()->get('code'))->firstOrFail();
		$request->session()->put('ujian_id', $ids->id);
		$nilai = new Nilai;
		$nilai->user_id = Auth::user()->id;
		$nilai->ujian_id = $ids->id;
		$nilai->save();
		$request->session()->put('nilai', $nilai->id);
		
		// $a = Ujian::where('code', '=', $request->code)->firstOrFail();

		// $soal = Soal::where('ujian_id', '=', $a->id)->firstOrFail();
		return redirect('user/accept/'.$request->session()->get('accept'));
	}
	public function choice(Request $request){
		$ujian_id = Ujian::where('code', '=', session()->get('code'))->firstOrFail();
		$soals = Soal::where('ujian_id', '=', $ujian_id->id)->paginate(1);
		$soalss = Soal::where('ujian_id', '=', $ujian_id->id)->get();
		$nilai_id = Nilai::where('id', '=', session()->get('nilai'))->firstOrFail();
		foreach($soals as $soal){
			$pilihan = Pilihan::where('Soal_id', '=', $soal->id)->get();
			$jawaban = DB::table('Jawabans')
			->where('user_id', Auth::user()->id)
			->where('soal_id', $soal->id)
			->where('nilai_id', session()->get('nilai'))->get();
		}
		$pilih = Pilihan::where('soal_id');
		$time = Carbon::now('Asia/Jakarta');
		return view('after/pilihan',[
			"title" => "Soal",
			"soals"=>$soals,
			"soalss" => $soalss,
			"jawabans" => $jawaban,
			"pilihans" => $pilihan,
			"ujian" => $ujian_id,
			"nilai" => $nilai_id,
			"time" => $time->toDateTimeString()
		]);
	}
	public function essay(){
		return view("after/essay",[
			"title"=>"essay",

		]);
	}
	public function store(Request $request, $random){
		$jawabans = DB::table('Jawabans')->where('user_id', Auth::user()->id)->where('soal_id', $request['id'])->where('nilai_id', session()->get('nilai'))->get();

		if($jawabans->isEmpty()){
			$save = new Jawaban;
			$save->jawaban = $request['jawaban'];
			$save->soal_id = $request['id'];
			$save->user_id = Auth::user()->id;
			$save->nilai_id = session()->get('nilai');
			$save->save();
			return $save->jawaban;
		}else{
			$jawaban = DB::table('jawabans')
			->where('user_id', Auth::user()->id)
			->where('soal_id', $request['id'])
			->where('nilai_id', session()->get('nilai'))
			->update([
				'jawaban' => $request['jawaban']
			]);
			
			return $jawaban;
		}
	}
	public function destroy(Request $request){
		$selects = Soal::where('ujian_id', '=', session()->get("ujian_id"))
		->where('type', '=', 'pilihan')->get();
		
		$soal = 0;
		$benar = 0;
		foreach ($selects as $select) {
			$soal++;
			$kunci = Kjawaban::where('soal_id', '=', $select->id)->firstOrFail();
			$jawaban = Jawaban::where('nilai_id', '=', session()->get("nilai"))
			->where('soal_id', '=', $select->id)->first();
			//
			if ($jawaban == null) {
				$benar = $benar+0;
			}else{
				if($kunci->jawaban == $jawaban->jawaban){
					$benar++;
				}
			}
		}
		if ($benar == 0) {
			$nilai = 0;
		}else{
			$nilai = 100*$benar/$soal;
		}
		$update = Nilai::where('id', '=', session()->get("nilai"))->update([
			'nilai' => $nilai
		]);
		$haha = Carbon::now('Asia/Jakarta');

		$request->session()->forget("accept");
		$request->session()->forget("code");
		$request->session()->forget("nilai");
		$request->session()->forget("ujian_id");


		return view('after/break',[
			'title'=> 'break'
		]);
	}

}
