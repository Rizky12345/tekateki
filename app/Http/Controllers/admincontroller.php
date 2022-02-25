<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\Kjawaban;
use App\Models\Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Image;

class admincontroller extends Controller
{
    public function index(){
        return view('admin/index',[
            "title"=>"admin"
        ]);
    }
    public function ujian(){
        $ujian = Ujian::where("user_id","=", Auth::user()->id)->get();
        return view('admin/ujian',[
            'title' => 'Ujian',
            'ujians'=>$ujian
        ]);
    }
    public function detail($code){
        $ujian = Ujian::where('code', '=', $code)->firstOrFail();
        $soals = Soal::where('ujian_id','=', $ujian->id)->get();
        $arr = collect([]);
        foreach($soals as $soal){
            $arr->push($soal->id);
        }
        $pilihans = Pilihan::whereIn('soal_id', $arr)->get();    
        return view('admin/detailUjian',[
            'ujian' => $ujian,
            'title'=> 'Detail',
            'soals'=> $soals,
            'pilihans' => $pilihans
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
            'title'=> 'Detail',
            'soals'=> $soals,
            'pilihans' => $pilihans,
            'kuncis'=>$kuncis
        ]);
    }
    public function edits(Request $request, $code){
        $ujian_id = Ujian::where('code','=',$code)->firstOrFail();
        $soal = Soal::where('ujian_id','=',$ujian_id->id)
        ->where('id','=',$request['id'])
        ->update([
            'soal' => $request['soal']
        ]);
        return $soal;
    }
    public function editspilihan(Request $request, $code){
        $pilihan = Pilihan::where('soal_id','=', $request->soal_id)
        ->where('id','=', $request->id)
        ->update([
            'pilihan'=>$request->pilihan
        ]);
        return $pilihan;
    }
    public function imageedit(Request $request, $code){
        for ($i=1; $i <= $request->soalcount; $i++) { 
            $validate = $request->validate([
                "soalfile$i" => 'image|file|max:2048'
            ]);
            $soal = Soal::where('id','=', $request->input("soalid$i"))->firstOrFail();
            

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
            $pilihan = Pilihan::where('id','=', $request->input("pilihanid$i"))->firstOrFail();

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
        $soal->soal = $request['soal'];
        $soal->type = $request['type'];
        $soal->ujian_id = $request['ujian_id'];
        $soal->save();

        return $soal;
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
            'timeupdate' => 'required'
        ]);
        $date = date('Y-m-d', strtotime($request->timeujian));
        $time = date('H:i:s', strtotime($request->timeujian));
        $request->timeujian = date('Y-m-d H:i:s', strtotime("$date $time"));
        $ujian = Ujian::where('code','=',$code)->firstOrFail();
        $time = Time::where('id','=',$ujian->time_id)->update([
            'date_time' => $request->timeujian,
            'time'=> $request->timeupdate
        ]);
        return back()->with('success', "berhasil");
    }
}
