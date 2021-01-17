<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TeacherMiddleware
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
            if($user->role != 'Teacher'){
                Session::flash('error_msg','Access Denied!...Teachers only!');
                return redirect('/home');
            }
        }
        else{
            return redirect('/login');
        }
        
        return $next($request);
    }
}
