<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\URL;

class CenterMiddleware
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
        if(Route::currentRouteName() == "center_login_index" || Route::currentRouteName() == "center_user_login_post") 
        {
            return $next($request);
        }
        if (Auth::check() && auth()->user() && (auth()->user()->userRoles->role_name === "Center")) {
            return $next($request);
        }
        // return $next($request);
        return redirect(route('center_login_index'))->with('error','Unauthorized Access, Please Login To Access area.');

    }
}
