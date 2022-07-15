<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Nilai;

class ujianeditstop
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
        $ujian = Ujian::where('code','=',$request->code)->first();
        $nilai = Nilai::where('ujian_id','=',$ujian->id)->get();
        if (!$nilai->isEmpty()) {
            return back()->with('ujian', 'ujian tidak bisa di edit, karena tercatat ada yang mengerjakan ujian ini');
        }
        return $next($request);
    }
}
