<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
           if($request->is('admin')    || $request->is('admin/*')
            ||$request->is('ar/admin') || $request->is('ar/admin/*')
            ||$request->is('en/admin') || $request->is('en/admin/*'))
                return route('selection');
            else
                return route('student.login.show');
            }
        }

    }

