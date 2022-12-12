<?php

namespace App\Http\Middleware\Center;

use Closure;
use Illuminate\Http\Request;

class CenterAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role_id = 9) {
            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
