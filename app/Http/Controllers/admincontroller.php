<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\Kjawaban;
use App\Models\Jawaban;
use App\Models\Time;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Kelase;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Exports\murid;

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
            "title"=>['Guru'],
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "user_nilai"=>$nilai_user,
            "ujian_all"=>$ujian_all
        ]);
    }
    public function ujianmonitoring(){
        $ujians = Ujian::where('user_id','=',Auth::user()->id)->orderBy('id','desc')->simplePaginate(10);
        $arr = collect([]);
        foreach($ujians as $ujian){
            $arr->push($ujian->id);
        }

        $time = Carbon::now();
        $y = date('Y', strtotime($time));
        $collect = collect([]);
        for ($i=2022; $i <= $y; $i++) { 
            $collect->push($i);
        }

        $nilai = Nilai::whereIn('ujian_id',$arr)->get();
        $user = User::where('kelase_id','=',Auth::user()->kelase_id)->where('level','=', "user")->get();
        $nilai_user = Nilai::where('user_id','=',Auth::user()->id)->get();
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->get();
        return view('admin/ujianlist',[
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "tahuns"=>$collect,
            "user_nilai"=>$nilai_user,
            "ujian_all"=>$ujian_all,
            'title'=>['guru','Ujian monitoring'],

        ]);
    }

    public function montoringcode($code){
        $ujian = Ujian::where('code','=',$code)->firstOrFail();
        $user_id = User::where('id','=',$ujian->user_id)->first();
        $nilais = Nilai::where('ujian_id','=',$ujian->id)->get();
        $collect = collect([]);
        foreach ($nilais as $nilai) {
            if ($nilai->type == NULL) {
                $collect->push($nilai);
            }
        }
        $group = $collect->unique('user_id');
        $users = User::where('kelase_id','=', $user_id->kelase_id)->where('level','=','user')->get();
        $soals = Soal::where('ujian_id','=',$ujian->id)->get();
        return view('admin/monitoringcode',[
            'ujian'=>$ujian,
            'title'=>['guru','ujian monitoring',$code],
            'nilais'=>$nilais,
            'users'=>$users,
            'group'=>$group,
            'soals'=>$soals
        ]);
    }
    public function essay($code){
        $ujian = Ujian::where('code','=',$code)->firstOrFail();
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
            'title'=>['guru','Ujian monitoring',$code,'essay'],
            'ujian'=>$ujian,
            'soals'=>$soals,
            'jawabans'=>$jawaban,
            'soal_count'=>$soal_count
        ]);
    }
    public function point(Request $request){

        $jawaban = Jawaban::where('id','=',$request->jawaban_id)->firstOrFail();
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
        $users = User::where('user_id','=',$user_id)->firstOrFail();
        if($users->kelase_id != Auth::user()->kelase_id){
            return back();
        }
        $kelas = Kelase::all();
        return view('sadmin/detail',[
            'user'=>$users,
            'kelases'=>$kelas,
            'title'=>['guru','user',$users->name],
        ]);
    }
    public function edituser(Request $request, $user_id){
        if($request->image == null && $request->password == null){
            $validate = $request->validate([
                'name'=>'required',
                'user_id'=>'required',
            ]);
            $account = User::where('user_id','=',$user_id)->first();
            $account_all = User::all();
            if($account->user_id == $request->user_id){
                $user = User::where('user_id','=',$user_id)->update([
                    'name'=>$request->name,
                    'user_id'=>$request->user_id,
                ]);
            }else{
                $collect = collect([]);
                foreach ($account_all as $all) {
                    if($all->user_id == $request->user_id){
                        $collect->push($all->user_id);
                    }   
                }
                if ($collect->count() >= 1) {
                    return redirect("admin/user/$user_id/$account->name")->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                    ]);
                }
            }
        }if($request->image != null){
            $validate = $request->validate([
                'name'=>'required',
                'user_id'=>'required',
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
                ]);
            }else{
                $collect = collect([]);
                foreach ($account_all as $all) {
                    if($all->user_id == $request->user_id){
                        $collect->push($all->user_id);
                    }   
                }
                if ($collect->count() >= 1) {
                    return redirect("admin/user/$user_id/$account->name")->with('info','Profile berhasil di ubah')->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                    ]);
                }
            }

        }if($request->password != null){
            $validate = $request->validate([
                'name'=>'required',
                'password'=>'required|min:6',
                'user_id'=>'required',
            ]);
            $account = User::where('user_id','=',$user_id)->first();
            $account_all = User::all();
            if($account->user_id == $request->user_id){
                if(Auth::user()->user_id == $request->user_id){
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                    ]);
                    Auth::user()->update(['password'=>Hash::make($request->password)]);
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'password'=>Hash::make($request->password),
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
                    return redirect("admin/user/$user_id/$account->name")->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
                }else{
                    $user = User::where('user_id','=',$user_id)->update([
                        'name'=>$request->name,
                        'user_id'=>$request->user_id,
                        'password'=>Hash::make($request->password),
                    ]);
                }
            }
        }
        $users = User::where('user_id','=',$request->user_id)->first();
        return redirect("admin/user/$users->user_id/$users->name")->with('info','Profile berhasil di ubah')->with('color','is-success');
    }
    public function naik_kelas(){
        $kelas = Kelase::where('id','=', auth()->user()->kelase_id)->firstOrFail();
        $user = User::where('kelase_id','=',$kelas->id)->where('level','=',"user")->get();
        return view('admin/kelas_up',[
            'title'=>['guru', 'Naik Kelas', $kelas->kelas],
            'users'=>$user,
            'kelas'=>$kelas,
            'count'=>0
        ]);
    }
    public function naik_kelas_upgrade(Request $request){
        $auth = auth()->user();
        if($auth->walikelas != "walikelas"){
            return redirect("/admin");
        }
        if (password_verify($request->password, $auth->password)) {
            for ($i=1; $i <= $request->max_count; $i++) {
                if ($request->input("checkbox$i") != null) {
                    $kelase_id = Kelase::where('id','=', $auth = auth()->user()->kelase_id)->firstOrFail();
                    $kelas = (int)$kelase_id->kelas + 1;
                    if( (int)$kelase_id->kelas == 6){
                        $lulus = Kelase::where('kelas','=','LULUS')->firstOrFail();
                        $update = User::where('id','=',$request->input("checkbox$i"))->update([
                            'kelase_id'=>$lulus->id
                        ]);
                        return redirect("admin/naik_kelas")->with('success','data sudah di update');
                    }
                    $letter = $kelase_id->kelas[1];
                    $merge = "$kelas$letter";
                    $kelas_where = Kelase::where('kelas','=',$merge)->first();
                    $update = User::where('id','=',$request->input("checkbox$i"))->update([
                        'kelase_id'=>$kelas_where->id
                    ]);
                }
            }
            return redirect("admin/naik_kelas")->with('success','data sudah di update');
        }else{
            return redirect("admin/naik_kelas")->with('failed','Password tidak valid');
        }
    }
    public function jadwal(){
        $user = auth()->user()->kelase->kelas;

        $jadwal1 = Jadwal::where('kelas','=','semua')->orderBy('id', 'DESC')->get();
        $jadwal2 = Jadwal::where('kelas','=',$user)->orderBy('id', 'DESC')->get();
        $now = Carbon::now();
        return view('admin/jadwal',[
            'title'=>['guru','Jadwal'],
            'jadwal_kelas'=>$jadwal2,
            'jadwal_semua'=>$jadwal1,
            'time'=>$now
        ]);
    }
    public function jadwal_id($id){
        $jadwal = Jadwal::where('id','=',$id)->firstOrFail();
        $nomer = 0;
        $nomer2 = 0;
        $sudah = collect([]);
        $sudah2 = collect([]);
        $kelases = Kelase::all();
        $collect_kelas = collect([]);
        $now = Carbon::now();
        foreach($kelases as $kelas){
            if ($kelas->kelas != 'LULUS') {
                $collect_kelas->push($kelas);
            }
        }
        if ($jadwal->target != "Pemberitahuan") {
            if($jadwal->target == "Jadwal ujian UAS"){
                $type = "uas";
            }elseif($jadwal->target == "Jadwal ujian UTS"){
                $type = "uts";
            }elseif($jadwal->target == "Jadwal ujian ujian harian"){
                $type = "ulangan harian";
            }

            if ($jadwal->kelas == 'semua') {
                foreach($collect_kelas as $kelas){
                    $wali = User::where('kelase_id','=',$kelas->id)->where('walikelas','=','walikelas')->first();
                    if ($wali != null) {
                        $ujian = Ujian::where('user_id','=',$wali->id)->where('type','=',$type)->where('semester','=',$jadwal->semester)->where('tahun_ajaran','=', $jadwal->tahun_ajaran)->first();

                        if ($ujian != null) {
                            // if ($jadwal->tahun_ajaran == $ujian->tahun_ajaran) {
                            $mapel = Mapel::where('id','=',$ujian->mapel_id)->first();

                            if ($sudah->contains($wali) == false) {
                                $arr = [$wali, 'created_at'=>$ujian->created_at, 'mapel'=>$mapel->mapel,'code_ujian'=>$ujian->code];
                                $sudah->push($arr);
                            }   
                            // }
                        }
                    }  
                }
            }else{
                $kelas = Kelase::where('kelas','=',$jadwal->kelas)->first();
                $walikelas = User::where('kelase_id','=',$kelas->id)->where('walikelas','=','walikelas')->first();

                if($walikelas != null){
                    $ujian = Ujian::where('user_id','=',$walikelas->id)->where('type','=',$type)->where('semester','=',$jadwal->semester)->where('tahun_ajaran','=', $jadwal->tahun_ajaran)->first();
                        // dd();
                    if ($ujian != null) {
                        // dd($ujian);


                        $mapel = Mapel::where('id','=',$ujian->mapel_id)->first();

                        if ($sudah->contains($walikelas) == false) {
                            $arr = [$walikelas,'created_at'=>$ujian->created_at, 'mapel'=>$mapel->mapel,'code_ujian'=>$ujian->code];
                            $sudah->push($arr);
                        }   
                        
                    }
                }
            }
        }

        return view('admin/jadwal_id',[
            'title'=>['guru', 'jadwal',"$jadwal->name"],
            'jadwal'=>$jadwal,
            'nomer'=>$nomer,
            'nomer2'=>$nomer,
            'sudahs'=>$sudah,
            'sudahs2'=>$sudah2
        ]);
    }
    public function user(){
        $user = User::where('kelase_id','=',auth()->user()->kelase_id)->where('level','=','user')->orderBy('id', 'DESC')->paginate(10);

        return view('admin/user',[
            'users'=>$user,
            'title'=>['Guru','Tambah murid'],
        ]);
    }
    public function user_proccess(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'sandi' => 'required',
            'user_id' => 'required|integer', 
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
        $user->password = Hash::make($request->sandi);
        $user->user_id = $request->user_id;
        $user->kelase_id = auth()->user()->kelase_id;
        $user->image = NULL;
        $user->level = 'user';
        $user->save();

        if ($user) {
            return redirect('admin/user')->with('success', 'Data berhasil di simpan');
        }else{
            return redirect('admin/user')->with('failed', 'Data gagal di simpan');
        }
    }
    public function user_murid(){
        $users = User::where('kelase_id','=',auth()->user()->kelase_id)->where('level','=','user')->orderBy('id','DESC')->get();
        $nomer = 0;
        return view('admin/murid',[
            'users'=>$users,
            'nomer'=>$nomer,
            'title'=>['guru','user','Semua murid']
        ]);
    }
    public function murid_excel(Excel $excel){
        $kelas = Kelase::where('id','=',auth()->user()->kelase_id)->first();
        return $excel->download(new murid, "$kelas->kelas.xlsx");
    }
}
