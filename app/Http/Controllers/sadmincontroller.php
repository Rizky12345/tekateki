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
use Illuminate\Support\Facades\DB;
use Image;

class sadmincontroller extends Controller
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
        $user_all = User::where('level','=',"user")->get();
        $nilai_user = Nilai::where('user_id','=',Auth::user()->id)->get();
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->get();
        return view('admin/index',[
            "title"=>['Super admin'],
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "user_all"=>$user_all,
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
            'title'=>['super admin','Ujian monitoring'],

        ]);
    }
    public function allujianmonitoring(){
        $ujians = Ujian::orderBy('id','desc')->get();
        $arr = collect([]);
        $arr2 = collect([]);
        $arr3 = collect([]);
        foreach($ujians as $ujian){
            $arr->push($ujian->id);
            $arr2->push($ujian->kelase_id);
        }
        $nilai = Nilai::whereIn('ujian_id',$arr)->get();

        $user = User::whereIn('kelase_id', $arr2)->where('level','=', "user")->get();
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
        $group = $nilai->unique('user_id');
        $users = User::where('kelase_id','=',Auth::user()->kelase_id)->where('level','=','user')->get();
        $soals = Soal::where('ujian_id','=',$ujian->id)->get();
        return view('admin/monitoringcode',[
            'ujian'=>$ujian,
            'title'=>['super admin','Ujian monitoring',$code],
            'nilais'=>$nilai,
            'users'=>$users,
            'group'=>$group,
            'soals'=>$soals
        ]);
    }
    public function essay($code){
        $ujian = Ujian::where('code','=',$code)->first();
        $soals = Soal::where('ujian_id','=',$ujian->id)->where('type','=','essay')->get();
        // $ujian = Ujian::where('code','=',$code)->first();
        // $soals_all = Soal::where('ujian_id','=',$ujian->id)->where('type','=','essay')->get();
        // $soal_count = 0;
        // foreach ($soals_all as $soal) {
        //     ++$soal_count;
        // }
        // $soals = Soal::where('ujian_id','=',$ujian->id)->where('type','=','essay')->paginate(1);
        // $users = User::where('kelase_id','=',Auth::user()->kelase_id)->get();
        // $arr = collect([]);
        // foreach($users as $user){
        //     $arr->push($user->id);
        // }
        $collect = collect([]);
        foreach ($soals as $soal) {
            $collect->push($soal->id);
        }

        $soalse = Soal::where('ujian_id','=',$ujian->id)->where('type','=','essay')->paginate(1);
        $jawaban = Jawaban::whereIn('soal_id',$collect)->get();

        return view('admin/essay',[
            'title'=>['super admin','Ujian monitoring',$code,'essay'],
            'ujian'=>$ujian,
            'soals'=>$soalse,
            'jawabans'=>$jawaban
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
    public function user(){
        $user = User::orderBy('id','desc')->paginate(10);
        $kelas = Kelase::all();

        return view('sadmin/user',[
            'users'=>$user,
            'title'=>['super admin','User'],
            'kelases'=>$kelas
        ]);
    }
    public function userprocess(Request $request){
        
        $validate = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'user_id' => 'required|integer', 
            'kelas' => 'required|integer',
            'level' => 'required',
        ]);

        $account_all = user::all();
$collect = collect([]);
                foreach ($account_all as $all) {
                    if($all->user_id == $request->user_id){
                        $collect->push($all->user_id);
                    }   
                }
                if ($collect->count() >= 1) {
                    return back()->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$request->user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'kelase_id'=>$request->kelase,
                        'level'=>$request->level,
                    ]);
                }
        $user = new User;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->user_id = $request->user_id;
        $user->kelase_id = $request->kelas;
        $user->image = NULL;
        $user->level = $request->level;
        $user->save();

        if ($user) {
            return redirect('s/admin/user')->with('success', 'Data berhasil di simpan');
        }else{
            return redirect('s/admin/user')->with('failed', 'Data gagal di simpan');
        }   
    }
    public function cari(Request $request){
        $satu = User::where('user_id','=',$request->id_user)->first();

        return back()->with('adaan','yeah');
    }
    public function alluser(){
        $users = User::all();
        $kelas = Kelase::all();
        return view('sadmin/userall',[
            'users'=>$users,
            'kelases'=>$kelas,
            'title'=>['super admin','user','Semua user']
        ]);
    }
    public function usercari(Request $request){
        if ($request->type == "id") {
            $user = User::where('user_id','=',$request->id)->get();
            return redirect('s/admin/user/alluser')->with('adaan',$user);
        }
        if ($request->type == "kelas") {
            $user = User::where('kelase_id','=',$request->kelas)->get();
            return redirect('s/admin/user/alluser')->with('adaan',$user);
        }
        if ($request->type == "level") {
            $user = User::where('level','=',$request->level)->get();
            return redirect('s/admin/user/alluser')->with('adaan',$user);
        }
    }
    public function detailuser($user_id){
        $users = User::where('user_id','=',$user_id)->first();
        $kelas = Kelase::all();
        return view('sadmin/detail',[
            'user'=>$users,
            'kelases'=>$kelas,
            'title'=>['super admin','user',$users->name],
        ]);
    }
    public function destroy(Request $request){
        $user = User::where('id','=',$request->id)->first();
        $nilai = Nilai::where('user_id','=', $user->id)->delete();
        $jawaban = Jawaban::where('user_id','=',$user->id)->delete();
        $kjawaban = Kjawaban::where('user_id','=',$user->id)->delete();
        $ujian = Ujian::where('user_id','=',$user->id)->delete();
        $users = User::where('id','=',$request->id)->delete();

        return back()->with('success','Pengguna di hapus');
    }
    public function edituser(Request $request, $user_id){
        if($request->image == null && $request->password == null){
            $validate = $request->validate([
                'name'=>'required',
                'user_id'=>'required|min:10',
                'kelase'=>'required',
                'level'=>'required',
            ]);
            $account = User::where('user_id','=',$user_id)->first();
            $account_all = User::all();
            if($account->user_id == $request->user_id){
                $user = User::where('user_id','=',$user_id)->update([
                    'name'=>$request->name,
                    'user_id'=>$request->user_id,
                    'kelase_id'=>$request->kelase,
                    'level'=>$request->level,
                ]);
            }else{
                $collect = collect([]);
                foreach ($account_all as $all) {
                    if($all->user_id == $request->user_id){
                        $collect->push($all->user_id);
                    }   
                }
                if ($collect->count() >= 1) {
                    return back()->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'kelase_id'=>$request->kelase,
                        'level'=>$request->level,
                    ]);
                }
            }
        }if($request->image != null){
            $validate = $request->validate([
                'name'=>'required',
                'user_id'=>'required|min:10',
                'kelase'=>'required',
                'level'=>'required',
                'image'=>'image|file|max:2048',
            ]);
            $account = User::where('user_id','=',$user_id)->first();
            if($account->image != null) {
                Storage::delete($account->image);
            }
            $filename = $request->file("image")->store('image');
            $user = User::where('user_id','=',$user_id)->update([
                'image'=>$filename
            ]);
            
            $account_all = User::all();
            if($account->user_id == $request->user_id){
                $user = User::where('user_id','=',$user_id)->update([
                    'name'=>$request->name,
                    'user_id'=>$request->user_id,
                    'kelase_id'=>$request->kelase,
                    'level'=>$request->level,
                ]);
            }else{
                $collect = collect([]);
                foreach ($account_all as $all) {
                    if($all->user_id == $request->user_id){
                        $collect->push($all->user_id);
                    }   
                }
                if ($collect->count() >= 1) {
                    return back()->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'kelase_id'=>$request->kelase,
                        'level'=>$request->level,
                    ]);
                }
            }

        }if($request->password != null){
            $validate = $request->validate([
                'name'=>'required',
                'password'=>'required|min:6',
                'user_id'=>'required|min:10',
                'kelase'=>'required',
                'level'=>'required',
            ]);
            $account = User::where('user_id','=',$user_id)->first();
            $account_all = User::all();
            if($account->user_id == $request->user_id){
                if(Auth::user()->user_id == $request->user_id){
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'kelase_id'=>$request->kelase,
                        'level'=>$request->level
                    ]);
                    Auth::user()->update(['password'=>Hash::make($request->password)]);
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'password'=>Hash::make($request->password),
                        'kelase_id'=>$request->kelase,
                        'level'=>$request->level
                    ]);
                }
            }else{
                $collect = collect([]);
                foreach ($account_all as $all) {
                    if($all->user_id == $request->user_id){
                        $collect->push($all->user_id);
                    }   
                }
                if ($collect->count() >= 1) {
                    return back()->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'password'=>Hash::make($request->password),
                        'kelase_id'=>$request->kelase,
                        'level'=>$request->level
                    ]);
                }
            }
        }
        $users = User::where('user_id','=',$request->user_id)->first();
        return redirect("s/admin/user/$users->user_id/$users->name")->with('alert', 'data berhasil di ubah')->with('color','is-success');
    }
}
