<?php

namespace App\Http\Middleware;

use App\Traits\Constants;
use Closure;

class ReferralCompleteMiddleware
{
    use Constants;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->check()){
            $user = auth()->User();
            if(optional($user->referral)->status != $this->activeStatus){
                session()->flash('error_msg','Acess Denied!...Activate your account to access this area!');
                return redirect('/home');
            }
        }
        else{
            return redirect('/login');
        }
        return $next($request);
    }
}
