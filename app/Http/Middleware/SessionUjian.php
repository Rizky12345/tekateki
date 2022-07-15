<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ujian;
use App\Models\Pilihan;
use App\Models\Soal;
use App\Models\Kjawaban;

class SessionUjian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = auth()->user();
        $ujians = Ujian::where('user_id','=',$auth->id)->get();
        $collect_ujian = collect([]);
        $collect_ujian_old = collect([]);
        if (!$ujians->isEmpty()) {
            foreach($ujians as $ujian){
                $soals = Soal::where('ujian_id','=',$ujian->id)->get();
                foreach($soals as $soal){
                    if($soal->image == null && $soal->soal == null){
                        if ($collect_ujian->contains($soal->ujian_id) == false) {
                            $collect_ujian->push($soal->ujian_id);
                        }
                    }
                    if ($soal->type == "pilihan") {
                        $pilihans = Pilihan::where('soal_id','=',$soal->id)->get();
                        $kjawaban = Kjawaban::where('soal_id','=',$soal->id)->first();
                        foreach($pilihans as $pilihan){
                            if ($pilihan->pilihan == null && $pilihan->image == null) {
                                if ($collect_ujian->contains($soal->ujian_id) == false) {
                                    $collect_ujian->push($soal->ujian_id);
                                }
                            }
                        }
                        if ($kjawaban == null) {
                            if ($collect_ujian->contains($soal->ujian_id) == false) {
                                $collect_ujian->push($soal->ujian_id);
                            }
                        }
                    }
                }
            }
            if ($collect_ujian->count() >= 1) {
                $collect_ujian_old = $collect_ujian;
                $ujian_collect = Ujian::wherein('id', $collect_ujian_old)->get();
                $request->session()->put('collect_ujian_old', $ujian_collect);
            }
        // dd(session('collect_ujian_old'));
            if (session('collect_ujian_old')) {
                foreach(session('collect_ujian_old') as $ujian){
                // dd($collect_ujian->contains($ujian->id));
                // dd($collect_ujian);
                // dd($ujian->id);
                // dd($collect_ujian->contains($ujian->id) == false);
                // dump($collect_ujian->contains($ujian->id));

                    if ($collect_ujian->contains($ujian->id) == false) {
                        $id = Ujian::where('id','=', $ujian->id)->first();

                        if ($id->oldos != null) {

                            $status = Ujian::where('id','=', $ujian->id)->update([
                                'status'=>$id->oldos
                            ]);
                        // dd($id);
                        // $status_old = Ujian::where('id','=', $ujian->id)->update([
                        //     'oldos'=>null,
                        // ]);
                        }
                    }
                }
            // dd();

            }
        // dd(session('collect_ujian_old'));
        // dd($collect_ujian_old);
            if (!$collect_ujian->isEmpty()) {
                if (!session('sessionujian')) {
                    foreach($collect_ujian as $ujian){
                        $id = Ujian::where('id','=', $ujian)->first();
                    // dd($id->status);
                        if($id->oldos == null){
                            $status_old = Ujian::where('id','=', $ujian)->update([
                                'oldos'=>$id->status
                            ]);
                        }
                    // dd($id->oldos);
                        $status = Ujian::where('id','=', $ujian)->update([
                            'status'=>'lock'
                        ]);
                    // dd($id->oldos);
                    }
                    $ujian = Ujian::whereIn('id', $collect_ujian)->get();
                    $request->session()->put('sessionujian', $ujian);
                }elseif(session('sessionujian')){
                    foreach($collect_ujian as $ujian){
                        $id = Ujian::where('id','=', $ujian)->first();

                        if($id->oldos != $id->status){
                            if ($id->oldos == null) {
                                $status_old = Ujian::where('id','=', $ujian)->update([
                                    'oldos'=>$id->status
                                ]);
                            }

                        }
                        $status = Ujian::where('id','=', $ujian)->update([
                            'status'=>'lock'
                        ]);
                    // dd($id);
                    }
                    session()->forget('sessionujian');
                    $ujian = Ujian::whereIn('id', $collect_ujian)->get();
                    $request->session()->put('sessionujian', $ujian);
                }
            // dd($collect_ujian->count() <= 1);
            }elseif($collect_ujian->count() < 1){ 
                $ujian = Ujian::where('user_id','=',$auth->id)->update([
                    'oldos' => null
                ]);
                if (session('collect_ujian_old')) {

                    session()->forget('collect_ujian_old'); 
                }
                session()->forget('sessionujian'); 
            }
        }
        if ($ujians->isEmpty()) {
            session()->forget('sessionujian'); 
            session()->forget('collect_ujian_old'); 
        }
        return $next($request);
    }
}
