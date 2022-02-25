<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Redirectskip
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
        if (Auth::user()->level == 'user') {
            return redirect('user');
        }
        if (Auth::user()->level == 'admin') {
            return redirect('admin');
        }
        if (Auth::user()->level == 'super admin') {
            return redirect('s/admin');
        }
    }
}
