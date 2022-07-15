<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\Kjawaban;
use App\Models\Time;
use App\Models\Nilai;
use App\Models\Jawaban;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Kelase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Image;

class allujiancontroller extends Controller
{
    public function ujian(){
        $ujian = Ujian::where("user_id","=", Auth::user()->id)->orderBy('id', 'desc')->simplePaginate(20);
        $time = Carbon::now();
        $y = date('Y', strtotime($time));
        $collect = collect([]);
        for ($i=2022; $i <= $y; $i++) { 
            $collect->push($i);
        }
        return view('admin/ujian',[
            'title' => ['Administrator','Ujian'],
            'ujians'=>$ujian,
            'tahuns'=>$collect
        ]);
    }
    public function detail($code){
        $ujian = Ujian::where('code', '=', $code)->firstOrFail();
        $soals = Soal::where('ujian_id','=', $ujian->id)->get();
        $kelases = Kelase::get();
        $collect = collect([]);
        
        foreach ($kelases as $kelas) {
            if ($kelas->kelas != "LULUS") {
                $collect->push($kelas);
            }
        }
        
        $mapels = Mapel::all();

        $arr = collect([]);
        foreach($soals as $soal){
            $arr->push($soal->id);
        }
        $pilihans = Pilihan::whereIn('soal_id', $arr)->get();
        $kuncis = Kjawaban::whereIn('soal_id',$arr)->get();
        return view('admin/detailUjian',[
            'ujian' => $ujian,
            'title'=> ['Administrator','Ujian','Detail'],
            'soals'=> $soals,
            'kelases'=> $collect,
            'mapels'=> $mapels,
            'pilihans' => $pilihans,
            'kuncis' => $kuncis,
        ]);
        
        
    }
    public function editsoal($code){
        $ujian = Ujian::where('code', '=', $code)->firstOrFail();
        $soals = Soal::where('ujian_id','=', $ujian->id)->get();
        $kuncis = Kjawaban::get();
        $arr = collect([]);
        foreach($soals as $soal){
            $arr->push($soal->id);
        }
        $pilihans = Pilihan::whereIn('soal_id', $arr)->get();    
        return view('admin/editsoal',[
            'ujian' => $ujian,
            'title'=> ['Administrator','Ujian','Detail','Edit'],
            'soals'=> $soals,
            'pilihans' => $pilihans,
            'kuncis'=>$kuncis
        ]);
    }
    public function edits(Request $request, $code){
        $ujian_id = Ujian::where('code','=',$code)->firstOrFail();
        $soal = Soal::where('ujian_id','=',$ujian_id->id)
        ->where('id','=',$request['soal_id'])
        ->update([
            'soal' => $request['value']
        ]);
        return $soal;
    }
    public function editspilihan(Request $request, $code){
        $pilihan = Pilihan::where('soal_id','=', $request->soal_id)
        ->where('id','=', $request->pilihan_id)
        ->update([
            'pilihan'=>$request->value
        ]);
        return $pilihan;
    }
    public function imageedit(Request $request, $code){

        for ($i=1; $i <= $request->soalcount; $i++) { 
            $validate = $request->validate([
                "soalfile$i" => 'image|file|max:2048'
            ]);
            $soal = Soal::where('id','=', $request->input("soalid$i"))->first();
            

            if ($validate != NULL) {
                if ($soal->image == NULL) {


                    $size = getimagesize($request->file("soalfile$i"));
                    $width = $size[0];
                    $height = $size[1];
                    if ($width-$height == 0) {
                        $width = 300;
                        $height = 300;
                    }
                    if($height > $width){
                        if ($height-$width <= 50) {
                            $width = 300;
                            $height = 300;
                        }else{
                            if ($width*2 < $height) {
                                $width = 300;
                                $height = 650;
                            }elseif($width < $height){
                                $width = 350;
                                $height = 500;
                            }
                        }
                    }
                    if($width>$height){
                        if ($width-$height <= 50) {
                            $width = 300;
                            $height = 300;
                        }else{
                            if ($height*2 < $width) {
                                $width = 650;
                                $height = 300;
                            }elseif($height < $width){
                                $width = 500;
                                $height = 350;
                            }
                        }
                    }
                    $image = $request->file("soalfile$i");
                    $filename = $request->file("soalfile$i")->store('image');
                    Storage::delete("$filename");
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize($width,$height);
                    $image_resize->save(storage_path('app/public/'.$filename));

                    $soal_update = Soal::where('id','=', $request->input("soalid$i"))->update([
                        "image" => $filename
                    ]);
                }else{
                    Storage::delete("$soal->image");
                    $size = getimagesize($request->file("soalfile$i"));
                    $width = $size[0];
                    $height = $size[1];

                    if ($width-$height == 0) {
                        $width = 300;
                        $height = 300;
                    }
                    if($height > $width){
                        if ($height-$width <= 50) {
                            $width = 300;
                            $height = 300;
                        }else{
                            if ($width*2 < $height) {
                                $width = 300;
                                $height = 650;
                            }elseif($width < $height){
                                $width = 350;
                                $height = 500;
                            }
                        }
                    }
                    if($width>$height){
                        if ($width-$height <= 50) {
                            $width = 300;
                            $height = 300;
                        }else{
                            if ($height*2 < $width) {
                                $width = 650;
                                $height = 300;
                            }elseif($height < $width){
                                $width = 500;
                                $height = 350;
                            }
                        }
                    } 
                    $image = $request->file("soalfile$i");
                    $filename = $request->file("soalfile$i")->store('image');
                    Storage::delete("$filename");
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize($width,$height);
                    $image_resize->save(storage_path('app/public/'.$filename));
                    $soal_update = Soal::where('id','=', $request->input("soalid$i"))->update([
                        "image" => $filename
                    ]);
                }
            }
        }
        for ($i=1; $i <= $request->pilihancount; $i++) {

            $validate = $request->validate([
                "pilihanfile$i" => 'image|file|max:2048'
            ]);
            $pilihan = Pilihan::where('id','=', $request->input("pilihanid$i"))->first();

            if ($validate != NULL) {
                if ($pilihan->image == NULL) {

                    $size = getimagesize($request->file("pilihanfile$i"));

                    $width = $size[0];
                    $height = $size[1];
                    if ($width-$height == 0) {
                        $width = 200;
                        $height = 200;
                    }
                    if($height > $width){
                        if ($height-$width <= 50) {
                            $width = 200;
                            $height = 200;
                        }else{
                            if ($width*2 < $height) {
                                $width = 200;
                                $height = 550;
                            }elseif($width < $height){
                                $width = 250;
                                $height = 400;
                            }
                        }
                    }
                    if($width>$height){
                        if ($width-$height <= 50) {
                            $width = 200;
                            $height = 200;
                        }else{
                            if ($height*2 < $width) {
                                $width = 550;
                                $height = 200;
                            }elseif($height < $width){
                                $width = 400;
                                $height = 250;
                            }
                        }
                    }

                    $image = $request->file("pilihanfile$i");

                    $filename = $request->file("pilihanfile$i")->store('image');
                    Storage::delete("$filename");
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize($width,$height);
                    $image_resize->save(storage_path('app/public/'.$filename));

                    $pilihan_update = Pilihan::where('id','=', $request->input("pilihanid$i"))->update([
                        "image" => $filename
                    ]);
                }else{
                    Storage::delete("$pilihan->image");
                    $size = getimagesize($request->file("pilihanfile$i"));
                    $width = $size[0];
                    $height = $size[1];
                    if ($width-$height == 0) {
                        $width = 200;
                        $height = 200;
                    }
                    if($height > $width){
                        if ($height-$width <= 50) {
                            $width = 200;
                            $height = 200;
                        }else{
                            if ($width*2 < $height) {
                                $width = 200;
                                $height = 550;
                            }elseif($width < $height){
                                $width = 250;
                                $height = 400;
                            }
                        }
                    }
                    if($width>$height){
                        if ($width-$height <= 50) {
                            $width = 200;
                            $height = 200;
                        }else{
                            if ($height*2 < $width) {
                                $width = 550;
                                $height = 200;
                            }elseif($height < $width){
                                $width = 400;
                                $height = 250;
                            }
                        }
                    }
                    $image = $request->file("pilihanfile$i");
                    $filename = $request->file("pilihanfile$i")->store('image');
                    Storage::delete("$filename");
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize($width,$height);
                    $image_resize->save(storage_path('app/public/'.$filename));
                    $pilihan_update = Pilihan::where('id','=', $request->input("pilihanid$i"))->update([
                        "image" => $filename
                    ]);
                }
            }
        }
        return redirect("admin/ujian/$code/edit")->with('success', 'Data berhasil disimpan');  
    }
    public function tambahsoal(Request $request){
        $soal = new Soal;
        $soal->soal = "";
        $soal->type = "pilihan";
        $soal->ujian_id = $request['ujian_id'];
        $soal->save();

        $pilihan1 = new Pilihan;
        $pilihan1->pilihan = "";
        $pilihan1->soal_id = $soal->id;
        $pilihan1->save();
        
        $pilihan2 = new Pilihan;
        $pilihan2->pilihan = "";
        $pilihan2->soal_id = $soal->id;
        $pilihan2->save();

        return [$soal, $pilihan1, $pilihan2];
    }
    public function tambahpilihan(Request $request){
        $pilihan = new Pilihan;
        $pilihan->pilihan = $request['pilihan'];
        $pilihan->soal_id = $request['soal_id'];
        $pilihan->save();

        return $pilihan;
    }
    public function type(Request $request){
        $soal = Soal::where('id', '=', $request->soal_id)
        ->update([
            'type'=>$request->type
        ]);

        return $soal;
    }
    public function kuncijawaban(Request $request){
        $jawaban = Kjawaban::where('soal_id','=',$request->soal_id)->get();
        if($jawaban->isEmpty()){
            $kunci = new Kjawaban;
            $kunci->jawaban = $request->jawaban;
            $kunci->soal_id = $request->soal_id;
            $kunci->pilihan_id = $request->pilihan_id;
            $kunci->user_id = Auth::user()->id;

            $kunci->save();
            return $kunci;
        }else{
            $kjawaban = Kjawaban::where('soal_id','=',$request->soal_id)
            ->update([
                'jawaban' => $request->jawaban,
                'pilihan_id'=>$request->pilihan_id,
                'user_id'=>Auth::user()->id
            ]);

            return $kjawaban;
        }
    }
    public function typedeletesoal(Request $request){
        $pilihans = Pilihan::where('soal_id','=',$request->soal_id)->get();
        foreach($pilihans as $pilihan){
            if ($pilihan->image != NULL) {
                $asd = Pilihan::where('id','=',$pilihan->id)->firstOrFail();
                Storage::delete($asd->image);
            }
            $asd = Pilihan::where('id','=',$pilihan->id)->delete();
        }
        $soal = Soal::where('id', '=', $request->soal_id)->firstOrFail();
        if ($soal->image != NULL) {
            Storage::delete($soal->image);
        }
        $soal = Soal::where('id', '=', $request->soal_id)->delete();
        
        return $soal;
        
    }
    public function typedeletepilihan(Request $request){
        $pilihan = Pilihan::where('id', '=', $request->pilihan_id)->firstOrFail();
        if ($pilihan->image != NULL) {
            Storage::delete($pilihan->image);
        }
        $pilihan->delete();

        return $pilihan;
    }
    public function destroyimage(Request $request){
        if ($request->ket == "gambar_soal") {
            $soal = Soal::where('id','=',$request->id)->firstOrFail();
            Storage::delete($soal->image);
            Soal::where('id','=',$request->id)->update([
                'image'=>NULL
            ]);
        }
        if ($request->ket == "gambar_pilihan") {
            $pilihan = Pilihan::where('id','=',$request->id)->firstOrFail();
            Storage::delete($pilihan->image);
            Pilihan::where('id','=',$request->id)->update([
                'image'=>NULL
            ]);
        }
    }
    public function timeujian(Request $request, $code){

        $validate = $request->validate([
            'timeupdate' => 'required',
            'judul' => 'required',
            'type'=> 'required',
            'mapel'=> 'required',
            'semester'=> 'required',
            'tahun_ajaran'=> 'required'
        ]);
        $ujian_id = Ujian::where('code','=',$code)->first();
        if (strlen($request->tahun_ajaran) == 9) {
            $tahun1 = $request->tahun_ajaran[0].$request->tahun_ajaran[1].$request->tahun_ajaran[2].$request->tahun_ajaran[3];

            $tahun2 = $request->tahun_ajaran[5].$request->tahun_ajaran[6].$request->tahun_ajaran[7].$request->tahun_ajaran[8];

            if (strlen((int)$tahun1) != 4) {
                return redirect('admin/ujian/'.$ujian_id->code)->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }
            $satu = (int)$tahun1+1;
            if (strlen((int)$tahun2) != 4 || (int)$tahun2 != $satu) {
                return redirect('admin/ujian/'.$ujian_id->code)->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }

        }else{
            return redirect('admin/ujian/'.$ujian_id->code)->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
        }
        // dd($request->mapel);
                if($request->tahun_ajaran){
            $ujian_mapel = Ujian::where('code','=',$code)->update([
                'tahun_ajaran'=>$request->tahun_ajaran
            ]);
        }
        if($request->mapel){
            $ujian_mapel = Ujian::where('code','=',$code)->update([
                'mapel_id'=>$request->mapel
            ]);
        }
        if($request->type){
            $ujian_type = Ujian::where('code','=',$code)->update([
                'type'=>$request->type
            ]);
        }
        
        if($ujian_id->judul != $request->judul){
            $ujian_update = Ujian::where('code','=',$code)->update([
                'judul'=>$request->judul
            ]);
        }
        if ($request->timeujian != NULL) {

            $date = date('Y-m-d', strtotime($request->timeujian));
            $time = date('H:i:s', strtotime($request->timeujian));
            $request->timeujian = date('Y-m-d H:i:s', strtotime("$date $time"));
            $ujian = Ujian::where('code','=',$code)->first();
            $time = Time::where('id','=',$ujian->time_id)->update([
                'date_time' => $request->timeujian,
                'time'=> $request->timeupdate
            ]);
            return back()->with('success', "Data Berhasil di Simpan");
        }else{
            $ujian = Ujian::where('code','=',$code)->firstOrFail();
            $time = Time::where('id','=',$ujian->time_id)->update([
                'date_time' => NULL,
                'time'=> $request->timeupdate
            ]);
            return back()->with('success', "Data Berhasil di Simpan");
        }
    }
    public function create(){
        $time = Carbon::now('Asia/Jakarta');
        $mont = date('m', strtotime($time));
        $mapel = Mapel::get();
        $kelases = Kelase::get();
        $collect = collect([]);
        foreach ($kelases as $kelas) {
            if ($kelas->kelas != "LULUS") {
                $collect->push($kelas);
            }
        }
        return view('admin/create',[
            'title'=>['Administrator','Ujian','Detail','Buat ujian'],
            'mapels'=>$mapel,
            'mont'=>$mont,
            'kelases'=>$collect,
        ]);
    }
    public function createprocess(Request $request){
        $validate = $request->validate([
            'judul'=>'required',
            'kelas'=>'required',
            'type'=>'required',
            'status'=>'required',
            'mapel'=>'required',
            'time'=>'required',
            'soal'=>'integer',
            'semester'=>'required',
        ]);
        $time = Carbon::now();
        $year = date('Y', strtotime($time));
        $mont = date('m', strtotime($time));
        $day = date('d', strtotime($time));
        $random = Str::random(1);
        $random2 = Str::random(1);
        $random3 = Str::random(1);
        $random4= Str::random(1);

if (strlen($request->tahun_ajaran) == 9) {
            $tahun1 = $request->tahun_ajaran[0].$request->tahun_ajaran[1].$request->tahun_ajaran[2].$request->tahun_ajaran[3];

            $tahun2 = $request->tahun_ajaran[5].$request->tahun_ajaran[6].$request->tahun_ajaran[7].$request->tahun_ajaran[8];

            if (strlen((int)$tahun1) != 4) {
                return redirect('admin/ujian/create')->with('gagal', 'tahun ajaran harus di isi contoh "2022/2023" tanpa tanda petik')->withErrors($validate, 'tahun ajaran');
            }
            $satu = (int)$tahun1+1;
            if (strlen((int)$tahun2) != 4 || (int)$tahun2 != $satu) {
                return redirect('admin/ujian/'.$ujian_id->code)->with('gagal', 'tahun ajaran tidak valid, contoh "2022/2023" tanpa tanda petik');
            }

        }else{
            return redirect('admin/ujian/create')->with('gagal', 'tahun ajaran harus di isi contoh "2022/2023" tanpa tanda petik ')->withErrors($validate, 'tahun ajaran');
        }
        $code = "$day[1]$random$day[0]$random2$mont$random3$year[2]$year[3]$random4";


        $date = date('Y-m-d', strtotime($request->ujiandatetime));
        $time = date('H:i:s', strtotime($request->ujiandatetime));
        $split_time = date('Y-m-d H:i:s', strtotime("$date $time"));

        $semester = $mont <= 06 ? "genap" : ($mont > 06 ? "ganjil" : 'genap');

        $time = new Time;
        $time->date_time = $split_time;
        $time->time = $request->time;
        $time->save();

        $ujian = new Ujian;
        $ujian->judul = $request->judul;
        $ujian->keterangan = $request->keterangan;
        $ujian->kelase_id = $request->kelas;
        $ujian->user_id = Auth::user()->id;
        $ujian->type = $request->type;
        $ujian->semester = $request->semester;
        $ujian->tahun_ajaran = $request->tahun_ajaran;
        $ujian->kkm = $request->kkm;
        $ujian->code = $code;
        $ujian->time_id = $time->id;
        $ujian->mapel_id = $request->mapel;
        $ujian->status = $request->status;
        $ujian->save();

        if($request->soal != NULL) {
            for($i=0;$i<$request->soal;$i++){
                $soal = new soal;
                $soal->soal = "";
                $soal->type = "pilihan";
                $soal->ujian_id = $ujian->id;
                $soal->save();

                for ($b=0; $b < 2; $b++) { 
                    $pilihan = new Pilihan;
                    $pilihan->pilihan = "";
                    $pilihan->soal_id = $soal->id;
                    $pilihan->save();
                }
            }
        }
        return redirect('s/admin/ujian/'.$ujian->code.'/edit')->with('berhasil', 'ujian berhasil ditambahkan');
    }
    public function judul(Request $request, $code){
        $ujian = Ujian::where('code','=',$code)->update([
            'judul'=>$request->judul
        ]);

        return $ujian;
    }
    public function status(Request $request, $code){
        $ujian = Ujian::where('code','=',$code)->update([
            'status'=>$request->value
        ]);

        return $ujian;
    }
    public function kelas(Request $request, $code){
        $kelas = Kelase::where('kelas','=',$request->value)->firstOrFail();
        $ujian = Ujian::where('code','=',$code)->update([
            'kelase_id' => $kelas->id
        ]);
        return $ujian;
    }
    public function allujian(){
        $ujian = Ujian::orderBy('id','desc')->simplePaginate(20);
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
        return view('sadmin/allujian',[
            'title' => ['Administrator','Semua ujian'],
            'ujians'=>$ujian,
            'tahuns'=>$collect,
            'kelases'=>$kelases_collect
        ]);
    }
    public function kkm(Request $request, $code){
        $ujian = Ujian::where('code','=',$code)->update([
            'kkm' => $request->value
        ]);
        return $ujian;
    }
    public function destroy(Request $request){
        $ujian = Ujian::where('id','=',$request->id)->first();
        $nilai = Nilai::where('ujian_id','=',$ujian->id)->delete();
        $soals = Soal::where('ujian_id','=', $ujian->id)->get();
        foreach ($soals as $soal) {
            $pilihan = Pilihan::where('soal_id','=',$soal->id)->delete();
        }
        $soals_destroy = Soal::where('ujian_id','=', $ujian->id)->delete();
        $ujian_destroy = Ujian::where('id','=',$request->id)->delete();
        return back()->with('success', 'ujian dihapus');
    }
    public function serahkan($code){
        $ujian = Ujian::where('code','=',$code)->update([
            'serahkan'=>'yes'
        ]);
        return redirect('s/admin/ujian/ujianmonitoring/'.$code)->with('success', 'Nilai ujian diserahkan');
    }
    public function periksa($code, $user_id, $nilai_id){
        $nilai = Nilai::where('id','=',$nilai_id)->first();
        $ujian = Ujian::where('code','=',$code)->first();
        if ($nilai->ujian_id != $ujian->id || $nilai->user_id != $user_id || $nilai->id != $nilai_id) {
            return abort(403);
        }
        $nilai = Nilai::where('id','=',$nilai_id)->first();
        $user = User::where('id','=',$user_id)->first();
        $soals = Soal::where('ujian_id','=',$nilai->ujian_id)->get();
        $collect = collect([]);
        foreach($soals as $soal){
            $collect->push($soal->id);
        }
        $pilihans = Pilihan::whereIn('soal_id', $collect)->get();
        $jawabans = Jawaban::where('nilai_id','=',$nilai_id)->get();
        $kjawabans = Kjawaban::whereIn('soal_id', $collect)->get();
        return view('admin/jawaban',[
            'title'=>['sadmin',"monitoring ujian $ujian->judul","Periksa Jawaban $user->name"],
            'soals'=>$soals,
            'pilihans'=>$pilihans,
            'jawabans'=>$jawabans,
            'kjawabans'=>$kjawabans,
        ]);
    }
    public function nilai_destroy(Request $request,$code, $user_id, $nilai_id){
        $nilai = Nilai::where('id','=',$request->nilai_id)->first();
        $ujian = Ujian::where('code','=',$code)->first();
        if ($nilai->ujian_id != $ujian->id || $nilai->user_id != $user_id || $nilai->id != $nilai_id) {
            return abort(403);
        }
        $nilai = Nilai::where('id','=',$request->nilai_id)->delete();
        return redirect('s/admin/ujian/ujianmonitoring/'.$code)->with('sukses', "Data di Hapus");
    }
    public function filter(Request $request){
        if ($request->tahun == null || $request->semester == null) {
            return redirect('s/admin/ujian')->with('filter_alert', "Filter gagal")->with('color','is-danger');
        }
        $auth = auth()->user();
        $filters = Ujian::where('semester','=',$request->semester)->where('user_id','=',$auth->id)->orderBy('id', 'DESC')->get();
        $collect = collect([]);
        foreach($filters as $filter){
            if (date('Y',strtotime($filter->created_at)) == $request->tahun) {
                $collect->push($filter);
            }
        }
        return redirect('s/admin/ujian')->with('filters', $collect)->with('filter_alert', "Filter berhasil")->with('color', 'is-success');
    }
    public function filter_monitor(Request $request){
        if ($request->tahun == null || $request->semester == null) {
            return redirect('s/admin/ujian/ujianmonitoring')->with('filter_alert', "Filter gagal")->with('color','is-danger');
        }
        $auth = auth()->user();
        $filters = Ujian::where('semester','=',$request->semester)->where('user_id','=',$auth->id)->orderBy('id', 'DESC')->get();
        $collect = collect([]);
        foreach($filters as $filter){
            if (date('Y',strtotime($filter->created_at)) == $request->tahun) {
                $collect->push($filter);
            }
        }
        return redirect('s/admin/ujian/ujianmonitoring')->with('filters', $collect)->with('filter_alert', "Filter berhasil")->with('color', 'is-success');
    }
    public function filter_all(Request $request){
        if ($request->tahun == null || $request->semester == null || $request->kelas == null) {
            return redirect('s/admin/ujian')->with('filter_alert', "Data filter harus di isi")->with('color','is-danger');
        }
        $filters = Ujian::where('semester','=',$request->semester)->where('kelase_id','=', $request->kelas)->orderBy('id', 'DESC')->get();
        $collect = collect([]);
        foreach($filters as $filter){
            if (date('Y',strtotime($filter->created_at)) == $request->tahun) {
                $collect->push($filter);
            }
        }
        return redirect('s/admin/ujian/all')->with('filters', $collect)->with('filter_alert', "Filter berhasil")->with('color', 'is-success');
    }
    public function filter_monitor_all(Request $request){
        if ($request->tahun == null || $request->semester == null || $request->kelas == null) {
            return redirect('s/admin/ujian/ujianmonitoring/all')->with('filter_alert', "Filter gagal")->with('color','is-danger');
        }
        $filters = Ujian::where('semester','=',$request->semester)->orderBy('id', 'DESC')->get();
        $collect = collect([]);
        foreach($filters as $filter){
            if (date('Y',strtotime($filter->created_at)) == $request->tahun) {
                $collect->push($filter);
            }
        }
        return redirect('s/admin/ujian/ujianmonitoring/all')->with('filters', $collect)->with('filter_alert', "Filter berhasil")->with('color', 'is-success');
    }
    public function filter_nilai(Request $request){
        if ($request->tahun == null || $request->semester == null) {
            return redirect('s/admin/ujian')->with('filter_alert', "Data filter harus di isi")->with('color','is-danger');
        }
        
        $filters = Ujian::where('semester','=',$request->semester)->orderBy('id', 'DESC')->get();
        $push = collect([]);
        foreach ($filters as $filter) {
            $push->push($filter->id);
        }
        $nilais = Nilai::wherein('ujian_id',$filters)->orderBy('id', 'DESC')->get();
        $collect = collect([]);
        foreach($nilais as $nilai){
            if (date('Y',strtotime($nilai->created_at)) == $request->tahun) {
                $collect->push($nilai);
            }
        }
        return redirect('s/admin/semua_nilai')->with('filters', $collect)->with('filter_alert', "Filter berhasil")->with('color', 'is-success');
    }
}
