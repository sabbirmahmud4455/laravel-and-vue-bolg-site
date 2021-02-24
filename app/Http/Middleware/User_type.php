<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class User_type
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
    
        if (Auth::user() && !Auth::user()->role_id == 0) {
             return $next($request);
        } elseif(Auth::user() && Auth::user()->role_id == 0){
            return redirect('/');
        }

        return redirect('/login')->with('error','You have not admin access');
    }
}