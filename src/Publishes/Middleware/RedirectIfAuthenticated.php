<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $main = app('user.logic')->getUser();
            if($main->admin){
                return redirect('/admin/index');
            }elseif($main->member){
                return redirect('/home/index');
            }else{
                return redirect('/open/index');
            }
        }

        return $next($request);
    }
}
