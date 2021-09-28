<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\URL;


class AdminMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if(Route::currentRouteName() == "admin_login_index" || Route::currentRouteName() == "user_login_post") 
        {
            
            return $next($request);
        }
        if (auth()->check() && auth()->user() && (auth()->user()->userRoles->role_name === "Super Admin" || auth()->user()->userRoles->role_name === "Admin")) {
            return $next($request);
        }
        // return $next($request);
        return redirect(route('admin_login_index'))->with('error','Unauthorized Access, Please Login To Access area.');
    }
}
