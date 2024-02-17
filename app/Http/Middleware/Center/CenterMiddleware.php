<?php

namespace App\Http\Middleware\Center;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CenterMiddleware
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
        if (!auth()->guard('admin')->check()) {

            if (request()->ajax() ) {
                $response = [
                    'state' => false,
                    'status' => 410,
                    'msg' => 'Authetication Required',
                    'params' => ['location' => route('admin.users.login')],
                    'callback' => 'redirect'
                ];
        
                $response = Response::make($response, 401);
                $response->header('Content-Type', 'application/json');

                return $response;
            }

            return redirect()->route('admin.users.list');
        }

        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin() && adminUser()->center_id) {
            return $next($request);
        }

        if (auth()->guard('admin')->check() ) {
            auth()->guard('admin')->logout();
        }

        return redirect()->route('login');
    }
}
