<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
public function handle($request, Closure $next)
    {
        if (Auth::guard()->check()) {
            if ($request->is('user') || $request->is('user/*')) {
                if (Auth::user()->level == 'user') {
                    return $next($request);
                } else {
                    return back();
                }
            } elseif ($request->is('admin') || $request->is('admin/*')) {
                if (Auth::user()->level == 'admin') {
                    return $next($request);
                } else {
                    return back();
                }
            } elseif ($request->is('s/admin') || $request->is('s/admin/*')) {
                if (Auth::user()->level == 'super admin') {
                    return $next($request);
                } else {
                    return back();
                }
            }            
        }else {
            return redirect('/login');
        }
    }
}
