<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


    public function handle(Request $request, Closure $next)
    {
      if(Auth::guard('teacher')->check() ||
         Auth::guard('trainer')->check() ||
         Auth::guard('admin')->check() ||
         Auth::guard('company')->check()){
        return redirect(RouteServiceProvider::HOME);
      }elseif(Auth::guard('student')->check()){
        return redirect(RouteServiceProvider::STUDENT);

      }


        return $next($request);
    }
}
