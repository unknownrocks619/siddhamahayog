<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // return view("portal.auth.login");
        // return view('auth.login');
        return view('frontend.page.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // role id = 1
        // admin
        if (auth()->user()->role_id == 1) {
            return redirect()->route('admin.admin_dashboard');
        }

        return redirect()->intended();
        /**
         * Center
         */
        if (auth()->user()->role_id == 2) {
        }

        /**
         * Lecturer
         */
        if (auth()->user()->role_id == 3) {
        }

        /**
         * Dharmashala
         */
        if (auth()->user()->role_id == 3) {
        }

        /**
         * 
         */
        if (auth()->user()->role_id == 4) {
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
