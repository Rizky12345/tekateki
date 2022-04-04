<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class sessionExistSadmin
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
        if (Auth::user()->level == "super admin") {
            if($request->session()->get("accept") && $request->session()->get("code")){
                return redirect("s/admin/ujian/".session()->get('code')."/tester/".session()->get('accept'));
            }
            return $next($request);
        }
    }
}
