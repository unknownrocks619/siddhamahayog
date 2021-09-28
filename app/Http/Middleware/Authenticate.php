<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
        // dd( $request->expectsJson());
        if( !$request->expectsJson() && $request->route()->getPrefix() == "admin") {
            return route('admin_login_index');
        } elseif ( ! $request->expectsJson()) {
            return route('login');
        }
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
