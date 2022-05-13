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
use Illuminate\Support\Collection;

class acceptusercontroller extends Controller
{
    public function index(Request $request){
        $a = Ujian::where('code', '=', $request->code)->first();
        if($a->status == 'lock'){
            return back()->with('alert', 'Ujian di kunci');
        }
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
        $request->session()->put('arr', collect([]));
        $ids = Ujian::where('code', '=', session()->get('code'))->firstOrFail();
        $request->session()->put('ujian_id', $ids->id);
        $nilai = new Nilai;
        $nilai->user_id = Auth::user()->id;
        $nilai->ujian_id = $ids->id;
        $nilai->type = NULL;
        $nilai->save();
        $request->session()->put('nilai', $nilai->id);
        
        // $a = Ujian::where('code', '=', $request->code)->firstOrFail();

        // $soal = Soal::where('ujian_id', '=', $a->id)->firstOrFail();
        return redirect("user/accept/".session('accept'));
    }
    public function choice(Request $request){

        $ujian_id = Ujian::where('code', '=', session()->get('code'))->first();
        $soals = Soal::where('ujian_id', '=', $ujian_id->id)->paginate(1);
        $soalss = Soal::where('ujian_id', '=', $ujian_id->id)->get();
        $nilai_id = Nilai::where('id', '=', session()->get('nilai'))->first();

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
}
