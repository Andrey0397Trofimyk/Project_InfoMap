<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckUser
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
        if(Auth::user() and Auth::user()->is_admin == 1)
        {
            return redirect()->route('admin.index');

        }else if(Auth::user() and Auth::user()->is_admin == 0){
            return $next($request);
        }
        return redirect()->guest('/');
    }
}
