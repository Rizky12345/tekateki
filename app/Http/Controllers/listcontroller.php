<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Rating;
use App\Models\Nilai;
use App\Models\Kjawaban;
use App\Models\Jawaban;
use App\Models\Soal;
use App\Models\Pilihan;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class listcontroller extends Controller
{
  public function index(){
    $list_umum = Ujian::where('umum','=','yes')->get();
    $list = Ujian::where('kelase_id','=',Auth::user()->kelase_id)->get();
    $collect = collect([]);
    foreach($list_umum as $umum){
      if ($collect->contains($umum->id) == false) {
        $collect->push($umum->id);
      }
    }
    foreach($list as $li){
      if ($collect->contains($li->id) == false) {
        $collect->push($li->id);
      }
    }
    $arr = Ujian::whereIn('id',$collect)->orderBy('id','desc')->paginate(10);
    $a = Rating::all();
    $ratingArr = $a->pluck('ujian_id');
    return view('after.list',[
      'lists'=> $arr,
      'ratings' => $a,
      'ratingArr' => $ratingArr,
      'title'=>'Home'
    ]);
  }
  public function code(Request $request){
    $ujian = Ujian::where('code','=',$request->code)->first();
    if ($ujian == null) {
      return redirect('user')->with('alert', 'Code tidak cocok')->with('color','has-text-danger');
    }
    if($ujian->status == 'lock'){
      return redirect('user')->with('alert', 'Ujian di kunci')->with('color','has-text-danger');
    }

    return redirect("user/accept/select/$request->code")->with('data', $ujian)->with('alert', 'Code sesuai')->with('color','has-text-success');
  }
  public function nilai(){
    $nilais = Nilai::where('user_id','=',Auth::user()->id)->get();

    $collect = collect([]);
    foreach($nilais as $nilai){
      if($nilai->ujian->serahkan == 'yes'){
        $collect->push($nilai->id);
      }
    }

    $result = Nilai::whereIn('id',$collect)->orderBy('id','desc')->get();
    return view('after/nilai',[
      'nilais'=>$result,
      'title'=>'Nilai'
    ]);
  }
  public function nilaicode($id, $code){
    $ujian = Ujian::where('code','=',$code)->first();
    $soals = Soal::where('ujian_id','=',$ujian->id)->get();
    $jawaban = Jawaban::where('nilai_id','=',$id)->get();
    $nilai = Nilai::where('id','=',$id)->first();
    $collect = collect([]);
    foreach($soals as $soal){
      $collect->push($soal->id);
    }
    $kjawaban = Kjawaban::whereIn('soal_id',$collect)->get();;
    $pilihans = Pilihan::whereIn('soal_id',$collect)->get();
    return view('after/jawaban',[
      'nilai'=>$nilai,
      'soals'=>$soals,
      'jawabans'=>$jawaban,
      'kjawabans'=>$kjawaban,
      'pilihans'=>$pilihans,
      'title'=>'Periksa'
    ]);
  }
  public function profile(){
    return view('after/profile',[
      'title'=>'Profile'
    ]);
  }
  public function ubah(Request $request){
    if ($request->image == null && $request->password == null) {
      return back()->with('alert','Form harus di isi')->with('color', 'is-danger');
    }
    $validate = $request->validate([
      "image" => 'image|file|max:2048'
    ]);
    if ($request->password != null) {
      if (Str::length($request->password) <= 5) {
      return back()->with('alert','password harus di isi minimal 6 karakrter')->with('color', 'is-danger');
    }else{
      Auth::user()->update(['password'=>Hash::make($request->password)]);
    }
    }
    if ($request->image != null) {
      if (Auth::user()->image != null) {
        Storage::delete(Auth::user()->image);
      }
      $filename = $request->file("image")->store('image');
      $user = User::where('id','=',Auth::user()->id)->update([
        'image'=>$filename
      ]);
    }
    return back()->with('alert','Profile berhasil di ubah')->with('color','is-success');
  }
}
