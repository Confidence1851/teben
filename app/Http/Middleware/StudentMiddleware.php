<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StudentMiddleware
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
        if(Auth::check()){
            $user = Auth::User();
            if($user->role != 'Student'){
                Session::flash('error_msg','Acess Denied!...Students only!');
                return redirect('/home');
            }
        }
        else{
            return redirect('/login');
        }
        
        return $next($request);
    }
}
