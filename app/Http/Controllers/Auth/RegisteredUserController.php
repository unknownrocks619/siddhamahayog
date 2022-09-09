<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\GoogleCaptcha;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view("frontend.page.auth.register");
        // return view("portal.auth.register");
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "recaptcha_token" => ["required", new GoogleCaptcha()]
        ]);

        $explode_name = explode(" ", $request->full_name);
        $first_name = $explode_name[0];
        $last_name = isset($explode_name[1]) ? $explode_name[1] : null;

        $member = new Member;
        $member->full_name = $request->full_name;
        $member->first_name = $first_name;
        $member->middle_name = null;
        $member->last_name = $last_name;
        $member->email = $request->email;
        $member->password = Hash::make($request->password);
        $member->role_id = 7;
        $member->save();

        // $user = Member::create([
        //     "full_name" => $request->full_name,
        //     "first_name" => $first_name,
        //     "middle_name" => null,
        //     "last_name" => $last_name,
        //     "email" => $request->email,
        //     "password" => Hash::make($request->password)
        // ])

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        event(new Registered($member));

        Auth::login($member);

        return redirect(RouteServiceProvider::HOME);
    }
}
