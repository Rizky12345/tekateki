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
	
	public function essay(){
		return view("after/essay",[
			"title"=>"essay",

		]);
	}
	public function testessay(Request $request, $random){
		$jawabans = Jawaban::where('user_id','=', Auth::user()->id)->where('soal_id','=',$request->soal_id)->where('nilai_id', session()->get('nilai'))->get();
		$ujian = Ujian::where('code','=',session()->get('code'))->first();
		if($jawabans->isEmpty()){
			$save = new Jawaban;
			$save->jawaban = $request['jawaban'];
			$save->soal_id = $request['soal_id'];
			$save->ujian_id = $ujian->id;
			$save->pilihan_id = NULL;
			$save->user_id = Auth::user()->id;
			$save->nilai_id = session()->get('nilai');
			$save->save();
			return $save;
		}else{
			$jawaban = Jawaban::where('user_id', Auth::user()->id)
			->where('soal_id', $request['soal_id'])
			->where('nilai_id', session()->get('nilai'))
			->update([
				'jawaban' => $request->jawaban
			]);
			
			return $jawaban;
		}
	}
	public function store(Request $request, $random){
		$jawabans = DB::table('Jawabans')->where('user_id', Auth::user()->id)->where('soal_id', $request['id'])->where('nilai_id', session()->get('nilai'))->get();
		$ujian = Ujian::where('code','=',session()->get('code'))->first();
		$collect = session('arr');
		$collect->push($request->page);
		if($jawabans->isEmpty()){
			$save = new Jawaban;
			$save->soal_id = $request['id'];
			$save->ujian_id = $ujian->id;
			$save->pilihan_id = $request['pilihan_id'];
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
				'jawaban' => $request['jawaban'],
				'pilihan_id' => $request['pilihan_id']
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
			$kunci = Kjawaban::where('soal_id', '=', $select->id)->first();
			if($kunci != NULL){
				$jawaban = Jawaban::where('nilai_id', '=', session()->get("nilai"))->where('soal_id', '=', $select->id)->first();
				if ($jawaban == null) {
					$benar = $benar+0;
				}else{
					if($kunci->pilihan_id == $jawaban->pilihan_id){
						$benar++;
					}else{
						$benar = $benar+0;
					}
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
	public function user_table(){
		return view('user_table');
	}
}
