<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\Kjawaban;
use App\Models\Time;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
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
        return view('admin/monitoringcode',[
            'ujian'=>$ujian,
            'title'=>['Admin','Ujian monitoring',$code],
            'nilais'=>$nilai,
            'users'=>$users
        ]);
    }
}
