<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class sessionExistAdmin
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
        if (Auth::user()->level == "admin") {
            if($request->session()->get("accept") && $request->session()->get("code")){
                return redirect("admin/ujian/".session()->get('code')."/tester/".session()->get('accept')."/tester");
            }
            return $next($request);
        }
    }
}
