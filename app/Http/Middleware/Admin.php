<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (Auth::user()) {
            if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'cs_person'){
                return $next($request);
            }else{
                return redirect('admin/login')->with('error','You have not admin access');
            }
        }
        return redirect('admin/login')->with('error','You have not admin access');
    }
}
