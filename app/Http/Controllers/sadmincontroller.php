<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\Kjawaban;
use App\Models\Jawaban;
use App\Models\Jadwal;
use App\Models\Time;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Kelase;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Image;
use Carbon\Carbon;
use App\Exports\ujianExport;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\NaikKelasRequest;
use App\Exports\murid_id;

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
        $user_all = User::where('level','=',"user")->where('kelase_id','=',Auth::user()->kelase_id)->get();
        $nilai_user = Nilai::where('user_id','=',Auth::user()->id)->get();
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->get();
        return view('admin/index',[
            "title"=>['Administrator'],
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "user_all"=>$user_all,
            "user_nilai"=>$nilai_user,
            "ujian_all"=>$ujian_all
        ]);
    }
    public function ujianmonitoring(){
        $ujians = Ujian::where('user_id','=',Auth::user()->id)->orderBy('id','desc')->simplePaginate(10);

        $time = Carbon::now();
        $y = date('Y', strtotime($time));
        $collect = collect([]);
        for ($i=2022; $i <= $y; $i++) { 
            $collect->push($i);
        }

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
            "tahuns"=>$collect,
            'title'=>['Administrator','Ujian monitoring'],

        ]);
    }
    public function allujianmonitoring(){
        $ujians = Ujian::orderBy('id','desc')->simplePaginate(10);
        $arr = collect([]);
        $arr2 = collect([]);
        $arr3 = collect([]);
        foreach($ujians as $ujian){
            $arr->push($ujian->id);
            $arr2->push($ujian->kelase_id);
        }

        $time = Carbon::now();
        $y = date('Y', strtotime($time));
        $collect = collect([]);
        for ($i=2022; $i <= $y; $i++) { 
            $collect->push($i);
        }

        $nilai = Nilai::whereIn('ujian_id',$arr)->get();
        $kelase = Kelase::all();
        $user = User::whereIn('kelase_id', $arr2)->where('level','=', "user")->get();
        $nilai_user = Nilai::where('user_id','=',Auth::user()->id)->get();
        $ujian_all = Ujian::where('user_id','=',Auth::user()->id)->get();
        return view('admin/ujianlist',[
            "ujians"=>$ujians,
            "nilais"=>$nilai,
            "users"=>$user,
            "kelases"=>$kelase,
            "user_nilai"=>$nilai_user,
            "ujian_all"=>$ujian_all,
            "tahuns"=>$collect,
            'title'=>['Administrator','Ujian monitoring'],

        ]);
    }
    public function montoringcode($code){
        $ujian = Ujian::where('code','=',$code)->first();
        $nilais = Nilai::where('ujian_id','=',$ujian->id)->get();
        $collect = collect([]);
        foreach ($nilais as $nilai) {
            if ($nilai->type == NULL) {
                $collect->push($nilai);
            }
        }
        $group = $collect->unique('user_id');
        $users = User::where('kelase_id','=',Auth::user()->kelase_id)->where('level','=','user')->get();
        $soals = Soal::where('ujian_id','=',$ujian->id)->get();
        return view('admin/monitoringcode',[
            'ujian'=>$ujian,
            'title'=>['Administrator','ujian monitoring',$code],
            'nilais'=>$nilais,
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
            'title'=>['Administrator','ujian monitoring',$code,'essay'],
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
            'title'=>['Administrator','User'],
            'kelases'=>$kelas
        ]);
    }
    public function userprocess(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'sandi' => 'required',
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
        $user->password = Hash::make($request->sandi);
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
        $kelases = Kelase::all();
        $collect = collect([]);
        foreach ($kelases as $kelas) {
            if ($kelas->kelas != "LULUS") {
                $collect->push($kelas);
            }
        }
        return view('sadmin/userall',[
            'users'=>$users,
            'kelases'=>$collect,
            'title'=>['Administrator','user','Semua user']
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
        $users = User::where('user_id','=',$user_id)->firstOrFail();
        $kelases = Kelase::all();

        return view('sadmin/detail',[
            'user'=>$users,
            'kelases'=>$kelases,
            'title'=>['Administrator','user',$users->name],
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
                'user_id'=>'required',
                'kelase'=>'required',
                'level'=>'required',
            ]);
            $account = User::where('user_id','=',$user_id)->first();
            if($account->level == "admin"){
                if ($request->walikelas) {
                    $keputusan = User::where('level','=','admin')->where('kelase_id','=',$request->kelase)->where('walikelas','=','walikelas')->first();
                    if ($keputusan == null || $account->id == $keputusan->id) {
                        if ($request->walikelas == "yes") {
                            $account_walikelas = User::where('user_id','=',$user_id)->update([
                                'walikelas'=>"walikelas"
                            ]);
                        }else{
                            $account_walikelas = User::where('user_id','=',$user_id)->update([
                                'walikelas'=>null
                            ]);
                        }
                    }else{
                        $kelasss = $keputusan->kelase->kelas;
                        return redirect("s/admin/user/$account->user_id/$account->name")->with('alert', "Walikelas dari kelas $kelasss sudah terisi")->with('color','is-danger'); 
                    }
                }
            }
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
                'user_id'=>'required',
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
                'user_id'=>'required',
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
                    return redirect("s/admin/user/$users->user_id/$users->name")->with('alert', 'user_id tidak boleh duplikat')->with('color','is-danger');                     
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
        $wallikelases = User::where('walikelas','=','walikelas')->get();
        foreach($wallikelases as $walikelas){
            if ($walikelas->level != 'admin') {
                $change = User::find($walikelas->id)->update([
                    'walikelas'=>null
                ]);
            }
        }
        $users = User::where('user_id','=',$request->user_id)->first();
        return redirect("s/admin/user/$users->user_id/$users->name")->with('alert', 'data berhasil di ubah')->with('color','is-success');
    }
    public function mapel(){
        $mapels = Mapel::all();
        
        $nomer = 0;

        return view('sadmin/mapel',[
            'mapels' => $mapels,
            'nomer'=> $nomer,
            "title"=>['Administrator', 'Mapel']
        ]);
    }
    public function mapel_tambah(Request $request){
        $validate = $request->validate([
            'mapel'=>'required'
        ]);
        $new = new Mapel;
        $new->mapel = $request->mapel;
        $new->save();

        return redirect('s/admin/mapel')->with('success', "Mapel berhasil di tambahkan");
    }
    public function mapel_destroy(Request $request){
        $mapel = Mapel::where('id','=',$request->id)->first();
        $ujian = Ujian::where('mapel_id','=',$mapel->id)->update([
            'mapel_id'=>510
        ]);
        $mapel_destroy = Mapel::where('id','=',$request->id)->delete();

        return redirect('s/admin/mapel')->with('success', "Mapel di hapus");
    }
    public function generate_code(Excel $excel, $code){
        return $excel->download(new ujianExport($code), "ujian_$code.xlsx");
    }
    public function naik_kelas(){
        $kelases = Kelase::all();
        $collect = collect([]);
        foreach ($kelases as $kelas) {
            if ($kelas->kelas != "LULUS") {
                $collect->push($kelas);
            }
        }
        return view('admin/naik_kelas',[
            'title'=>["Administrator","Naik Kelas"],
            'kelases'=>$collect
        ]);
    }
    public function naik_kelas_id($id){
        $kelas = Kelase::where('id','=', $id)->firstOrFail();
        $user = User::where('kelase_id','=',$kelas->id)->where('level','=',"user")->get();

        return view('admin/kelas_up',[
            'title'=>['Administrator', 'Naik Kelas', $kelas->kelas],
            'users'=>$user,
            'kelas'=>$kelas,
            'count'=>0
        ]);
    }
    public function naik_kelas_id_upgrade(NaikKelasRequest $request, $id){
        $auth = auth()->user();
        if (password_verify($request->password, $auth->password)) {
            for ($i=1; $i <= $request->max_count; $i++) {
                if ($request->input("checkbox$i") != null) {
                    $kelase_id = Kelase::where('id','=', $id)->firstOrFail();
                    $kelas = (int)$kelase_id->kelas + 1;
                    if( (int)$kelase_id->kelas == 6){
                        $lulus = Kelase::where('kelas','=','LULUS')->firstOrFail();
                        $update = User::where('id','=',$request->input("checkbox$i"))->update([
                            'kelase_id'=>$lulus->id
                        ]);
                        return redirect("s/admin/naik_kelas/$id")->with('success','data sudah di update');
                    }
                    $letter = $kelase_id->kelas[1];
                    $merge = "$kelas$letter";
                    $kelas_where = Kelase::where('kelas','=',$merge)->first();
                    $update = User::where('id','=',$request->input("checkbox$i"))->update([
                        'kelase_id'=>$kelas_where->id
                    ]);
                }
            }
            return redirect("s/admin/naik_kelas/$id")->with('success','data sudah di update');
        }else{
            return redirect("s/admin/naik_kelas/$id")->with('failed','Password tidak valid');
        } 
    }
    public function semua_nilai(){
        $nilais = Nilai::all();
        $count = 0;
        $foreach = 0;
        $arr = collect([]);
        foreach($nilais as $nilai){
            if ($nilai->nilai < $nilai->ujian->kkm) {
                $arr->push($nilai);
            }else{
                $arr->push($nilai);
            }
        }
        $time = Carbon::now();
        $y = date('Y', strtotime($time));
        $collect = collect([]);
        for ($i=2022; $i <= $y; $i++) { 
            $collect->push($i);
        }
        $kelases = Kelase::get();
        $kelases_collect = collect([]);
        
        foreach ($kelases as $kelas) {
            if ($kelas->kelas != "LULUS") {
                $kelases_collect->push($kelas);
            }
        }
        return view('sadmin/semua_nilai',[
            'title'=>['Administrator', 'Semua Nilai'],
            'nilais'=>$arr,
            'count'=>$count,
            'kelases'=>$kelases_collect,
            'tahuns'=>$collect
        ]);
    }
    public function jadwal(){
        $jadwals = Jadwal::orderBy('id','DESC')->get();
        $time = Carbon::now();
        return view('sadmin/jadwal',[
            'title'=>['Administrator','Jadwal'],
            'jadwals'=>$jadwals,
            'time'=>$time
        ]);
    }
    public function jadwal_create(){
        $kelases = Kelase::all();
        $collect_kelas = collect([]);
        foreach($kelases as $kelas){
            if ($kelas->kelas != 'LULUS') {
                $collect_kelas->push($kelas);
            }
        }
        $mapel = Mapel::all();
        // dd($collect_kelas);
        return view('sadmin/jadwal_create',[
            'title'=>['Administrator','Jadwal'],
            'kelases'=>$collect_kelas,
            'mapels'=>$mapel
        ]);
    }
    public function jadwal_create_proccess(Request $request){
        if ($request->target != null) {
            if($request->target != "Pemberitahuan"){
                $validate = $request->validate([
                    'kelas'=>'required',
                    'target'=>'required',
                    'catatan'=>'required',
                    'name'=>'required',
                    'semester'=>'required',
                    'mapel'=>'required',
                    'tanggal'=>'required',
                    'tahun_ajaran'=>'required'
                ]);
            }else{
                $validate = $request->validate([
                    'kelas'=>'required',
                    'target'=>'required',
                    'catatan'=>'required',
                    'name'=>'required'
                ]);
            }
        }else{
            $validate = $request->validate([
                'kelas'=>'required',
                'target'=>'required',
                'catatan'=>'required',
                'name'=>'required',
                'semester'=>'required',
                'mapel'=>'required',
                'tanggal'=>'required',
                'tahun_ajaran'=>'required'
            ]);
        }
        if (strlen($request->tahun_ajaran) == 9) {
            $tahun1 = $request->tahun_ajaran[0].$request->tahun_ajaran[1].$request->tahun_ajaran[2].$request->tahun_ajaran[3];

            $tahun2 = $request->tahun_ajaran[5].$request->tahun_ajaran[6].$request->tahun_ajaran[7].$request->tahun_ajaran[8];

            if (strlen((int)$tahun1) != 4) {
                return redirect('s/admin/ujian/create')->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }
            $satu = (int)$tahun1+1;
            if (strlen((int)$tahun2) != 4 || (int)$tahun2 != $satu) {
                return redirect('s/admin/ujian/create')->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }

        }else{
            return redirect('s/admin/ujian/create')->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
        }
        if ($request->target == 'Pemberitahuan') {
            $new = new Jadwal;
            $new->kelas = $request->kelas;
            $new->target = $request->target;
            $new->catatan = $request->catatan;
            $new->tanggal = null;
            $new->semester = null;
            $new->mapel = null;
            $new->tahun_ajaran = null;
            $new->name = $request->name;
            $new->save();
        }else{
            $new = new Jadwal;
            $new->kelas = $request->kelas;
            $new->target = $request->target;
            $new->catatan = $request->catatan;
            $new->tanggal = $request->tanggal;
            $new->semester = $request->semester;
            $new->mapel = $request->mapel;
            $new->name = $request->name;
            $new->tahun_ajaran = $request->tahun_ajaran;
            $new->save();
        }
        

        return redirect('s/admin/jadwal/create')->with('success', 'Data berhasil di simpan');
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
                        $ujian = Ujian::where('user_id','=',$wali->id)->where('type','=',$type)->where('semester','=',$jadwal->semester)->first();
                        if ($ujian != null) {


                            if ($jadwal->tahun_ajaran == $ujian->tahun_ajaran) {
                                $mapel = Mapel::where('id','=',$ujian->mapel_id)->first();

                                if ($sudah->contains($wali) == false) {
                                    $arr = [$wali, 'created_at'=>$ujian->created_at, 'mapel'=>$mapel->mapel,'code_ujian'=>$ujian->code];
                                    $sudah->push($arr);
                                }                               
                            }
                        }
                    }  
                }
            }else{
                $kelas = Kelase::where('kelas','=',$jadwal->kelas)->first();
                $walikelas = User::where('kelase_id','=',$kelas->id)->where('walikelas','=','walikelas')->first();

                if($walikelas != null){
                    $ujian = Ujian::where('user_id','=',$walikelas->id)->where('type','=',$type)->where('semester','=',$jadwal->semester)->first();
                    if ($ujian != null) {
                        if (date('Y',strtotime($jadwal->tanggal)) == date('Y',strtotime($ujian->created_at))) {
                            $mapel = Mapel::where('id','=',$ujian->mapel_id)->first();

                            if ($sudah->contains($walikelas) == false) {
                                $arr = [$walikelas,'created_at'=>$ujian->created_at, 'mapel'=>$mapel->mapel,'code_ujian'=>$ujian->code];
                                $sudah->push($arr);
                            }   
                        }
                    }
                }
            }
        }
    // dd($sudah);
        return view('sadmin/jadwal_id',[
            'title'=>['Administrator', 'jadwal',"$jadwal->name"],
            'jadwal'=>$jadwal,
            'nomer'=>$nomer,
            'nomer2'=>$nomer,
            'sudahs'=>$sudah,
            'sudahs2'=>$sudah2
        ]);
    }
    public function jadwal_id_edit($id){
        $jadwal = Jadwal::where('id','=',$id)->firstOrFail();
        $kelases = Kelase::all();
        $collect_kelas = collect([]);
        foreach($kelases as $kelas){
            if ($kelas->kelas != 'LULUS') {
                $collect_kelas->push($kelas);
            }
        }
        $mapel = Mapel::all();
        return view('sadmin/jadwal_id',[
            'title'=>['Administrator', 'jadwal',"$jadwal->name","Edit"],
            'jadwal'=>$jadwal,
            'kelases'=>$collect_kelas,
            'mapels'=>$mapel
        ]);
    }
    public function jadwal_id_edit_process(Request $request, $id){
        if ($request->target != null) {
            if($request->target != "Pemberitahuan"){
                $validate = $request->validate([
                    'kelas'=>'required',
                    'target'=>'required',
                    'catatan'=>'required',
                    'name'=>'required',
                    'semester'=>'required',
                    'mapel'=>'required',
                    'tanggal'=>'required',
                    'tahun_ajaran'=>'required'
                ]);
            }else{
                $validate = $request->validate([
                    'kelas'=>'required',
                    'target'=>'required',
                    'catatan'=>'required',
                    'name'=>'required'
                ]);
            }
        }else{
            $validate = $request->validate([
                'kelas'=>'required',
                'target'=>'required',
                'catatan'=>'required',
                'name'=>'required',
                'semester'=>'required',
                'mapel'=>'required',
                'tanggal'=>'required',
                'tahun_ajaran'=>'required'
            ]);
        }
        $jadwal_id = Jadwal::where('id','=',$id)->first();
        if (strlen($request->tahun_ajaran) == 9) {
            $tahun1 = $request->tahun_ajaran[0].$request->tahun_ajaran[1].$request->tahun_ajaran[2].$request->tahun_ajaran[3];

            $tahun2 = $request->tahun_ajaran[5].$request->tahun_ajaran[6].$request->tahun_ajaran[7].$request->tahun_ajaran[8];

            if (strlen((int)$tahun1) != 4) {
                return redirect("s/admin/jadwal/$jadwal_id->id/edit")->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }
            $satu = (int)$tahun1+1;
            if (strlen((int)$tahun2) != 4 || (int)$tahun2 != $satu) {
                return redirect("s/admin/jadwal/$jadwal_id->id/edit")->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }

        }else{
            return redirect("s/admin/jadwal/$jadwal_id->id/edit")->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
        }
        
        if ($request->target == 'Pemberitahuan') {

            $jadwal = Jadwal::where('id','=',$id)->update([
                'kelas'=>$request->kelas,
                'tanggal'=>null,
                'target'=>$request->target,
                'catatan'=>$request->catatan,
                'name'=>$request->name,
                'semester'=>null,
                'mapel'=>null,
                'tahun_ajaran'=>'null'
            ]);
        }else{
            $jadwal = Jadwal::where('id','=',$id)->update([
                'kelas'=>$request->kelas,
                'tanggal'=>$request->tanggal,
                'target'=>$request->target,
                'catatan'=>$request->catatan,
                'name'=>$request->name,
                'semester'=>$request->semester,
                'mapel'=>$request->mapel,
                'tahun_ajaran'=>$request->tahun_ajaran,

            ]);
        }

        return redirect("s/admin/jadwal/$jadwal_id->id/edit")->with('success', 'Data berhasil di simpan');
    }
    public function jadwal_id_destroy($id){
        $jadwal = Jadwal::where('id','=',$id)->delete();
        return redirect('s/admin/jadwal')->with('success', 'Jadwal dihapus');
    }
    public function naik_kelas_id_excel(Excel $excel, $id){
        $kelas = Kelase::find($id);
        return $excel->download(new murid_id($id), "$kelas->kelas.xlsx");
    }
}
