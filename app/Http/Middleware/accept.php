<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Accept
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
        if($request->route()->parameter('random') != $request->session()->get('accept')){
            return redirect('/user');
        }
        return $next($request);
    }
}
