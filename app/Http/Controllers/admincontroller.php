<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\Kjawaban;
use App\Models\Jawaban;
use App\Models\Time;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Kelase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Image;

class admincontroller extends Controller
{
    public function index(){
        $ujians = Ujian::where('user_id','=',Auth::user()->id)->orderBy('id', 'desc')->paginate(3);
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->orderBy('id','desc')->get();
        $arr = collect([]);
        foreach($ujian_all as $ujian){
            $arr->push($ujian->id);
        }
        $nilai = Nilai::whereIn('ujian_id',$arr)->get();
        $user = User::where('kelase_id','=',Auth::user()->kelase_id)->where('level','=', "user")->get();
        $nilai_user = Nilai::where('user_id','=',Auth::user()->id)->get();
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->get();
        return view('admin/index',[
            "title"=>['Admin'],
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "user_nilai"=>$nilai_user,
            "ujian_all"=>$ujian_all
        ]);
    }
    public function ujianmonitoring(){
        $ujians = Ujian::where('user_id','=',Auth::user()->id)->orderBy('id','desc')->get();
        $arr = collect([]);
        foreach($ujians as $ujian){
            $arr->push($ujian->id);
        }
        $nilai = Nilai::whereIn('ujian_id',$arr)->get();
        $user = User::where('kelase_id','=',Auth::user()->kelase_id)->where('level','=', "user")->get();
        $nilai_user = Nilai::where('user_id','=',Auth::user()->id)->get();
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->get();
        return view('admin/ujianlist',[
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "user_nilai"=>$nilai_user,
            "ujian_all"=>$ujian_all,
            'title'=>['Admin','Ujian monitoring'],

        ]);
    }
       
    public function montoringcode($code){
        $ujian = Ujian::where('code','=',$code)->first();
        $nilai = Nilai::where('ujian_id','=',$ujian->id)->get();
        $users = User::where('kelase_id','=',Auth::user()->kelase_id)->where('level','=','user')->get();
        $soals = Soal::where('ujian_id','=',$ujian->id)->get();
        return view('admin/monitoringcode',[
            'ujian'=>$ujian,
            'title'=>['Admin','Ujian monitoring',$code],
            'nilais'=>$nilai,
            'users'=>$users,
            'soals'=>$soals
        ]);
    }
    public function essay($code){
        $ujian = Ujian::where('code','=',$code)->first();
        $soals_all = Soal::where('ujian_id','=',$ujian->id)->where('type','=','essay')->get();
        $soal_count = 0;
        foreach ($soals_all as $soal) {
            ++$soal_count;
        }
        $soals = Soal::where('ujian_id','=',$ujian->id)->where('type','=','essay')->paginate(1);
        $users = User::where('kelase_id','=',Auth::user()->kelase_id)->get();
        $arr = collect([]);
        foreach($users as $user){
            $arr->push($user->id);
        }
        $jawaban = Jawaban::whereIn('user_id',$arr)->where('ujian_id','=', $ujian->id)->where('pilihan_id','=', NULL)->get();

        return view('admin/essay',[
            'title'=>['Admin','Ujian monitoring',$code,'essay'],
            'ujian'=>$ujian,
            'soals'=>$soals,
            'jawabans'=>$jawaban,
            'soal_count'=>$soal_count
        ]);
    }
    public function point(Request $request){

        $jawaban = Jawaban::where('id','=',$request->jawaban_id)->first();
        $nilai = Nilai::where('id','=',$jawaban->nilai_id)->first();
        $ujian = Ujian::where('id','=',$nilai->ujian_id)->first();
        $soals = Soal::where('ujian_id','=',$ujian->id)->get();
        $count = 0;
        foreach ($soals as $soal) {
            ++$count;
        }
        if ($jawaban->point != 0) {
            $benar = $nilai->nilai*$count/100;
            $hasil_benar = $benar-$jawaban->point;
            $hasil = $hasil_benar/$count*100;
            $nilai_count = Nilai::where('id','=',$jawaban->nilai_id)->update([
                'nilai'=>$hasil
            ]);

            $jawaban_update = Jawaban::where('id','=',$request->jawaban_id)->update([
                'point'=>$request->value
            ]);



            $jawabans = Jawaban::where('id','=',$request->jawaban_id)->first();

            $nilais = Nilai::where('id','=',$jawaban->nilai_id)->first();

            $benars = $nilais->nilai*$count/100;
            $hasil_benars = $benars+$jawabans->point;
            $hasils = $hasil_benars/$count*100;
            $nilai_count = Nilai::where('id','=',$jawabans->nilai_id)->update([
                'nilai'=>$hasils
            ]);
            return $nilai_count;
        }else{
            $jawaban_update = Jawaban::where('id','=',$request->jawaban_id)->update([
                'point'=>$request->value
            ]);
            $jawabans = Jawaban::where('id','=',$request->jawaban_id)->first();
            $benar = $nilai->nilai*$count/100;
            $hasil_benar = $benar+$jawabans->point;
            $hasil = $hasil_benar/$count*100;

            $nilai_count = Nilai::where('id','=',$jawaban->nilai_id)->update([
                'nilai'=>$hasil
            ]);

            return $nilai_count;
        }
    }
        public function detailuser($user_id){
        $users = User::where('user_id','=',$user_id)->first();
        if($users->id != Auth::user()->id){
            return back();
        }
        $kelas = Kelase::all();
        return view('sadmin/detail',[
            'user'=>$users,
            'kelases'=>$kelas,
            'title'=>['super admin','user',$users->name],
        ]);
    }
    public function edituser(Request $request, $user_id){
        $validate = $request->validate([
            'password' => 'required|min:6'
        ]);

        $user = User::where('user_id','=',$user_id)->update([
            'password'=>Hash::make($request->password)
        ]);
        Auth::user()->update(['password'=>Hash::make($request->password)]);
        
        return back()->with('alert','password telah di ubah');
    }
}
