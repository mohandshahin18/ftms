<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

trait AuthTrait
{
    public function chekGuard($request){

        if($request->type == 'teacher'){
            $guardName= 'teacher';
        }
        elseif ($request->type == 'trainer'){
            $guardName= 'trainer';
        }
        elseif ($request->type == 'admin'){
            $guardName= 'admin';
        }
        elseif ($request->type == 'company'){
            $guardName= 'company';
        }
        return $guardName;
    }

    public function redirect($request){

        if($request->type == 'teacher' ||
            $request->type == 'trainer' ||
            $request->type == 'admin' ||
            $request->type == 'company' ){
            return redirect()->intended(RouteServiceProvider::HOME);
        }

    }

}
