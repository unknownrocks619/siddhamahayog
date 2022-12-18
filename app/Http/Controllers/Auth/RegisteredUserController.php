<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Reference;
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
        $referer = null;
        if ((int) request()->ref) {
            // check if user was recommended.
            $referer_detail = Member::where('sharing_code', request()->ref)->first();
            if ($referer_detail) {
                $referer = $referer_detail->sharing_code;
                session()->put("_refU", ["id" => $referer_detail->id, "referrer" => $referer]);
            }
        }
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
            'first_name' => ["required", 'string', 'max:52'],
            'last_name' => ['required', 'string', 'max:52'],
            // 'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "recaptcha_token" => ["required", new GoogleCaptcha()]
        ]);

        $unicode_character = check_unicode_character($request->all());
        if ($unicode_character) {
            session()->flash('error', 'Unicode Character not Supported');
            return back()->withInput()->withErrors($unicode_character);
        }


        $explode_name = explode(" ", $request->full_name);
        $first_name = $explode_name[0];
        $last_name = isset($explode_name[1]) ? $explode_name[1] : null;

        $member = new Member;
        $member->full_name = strip_tags($request->post('first_name')) . ' ' . strip_tags($request->post('last_name'));
        $member->first_name = strip_tags($request->post('first_name'));
        $member->middle_name = null;
        $member->last_name = strip_tags($request->post('last_name'));
        $member->email = $request->email;
        $member->password = Hash::make($request->password);
        $member->role_id = 7;
        $member->save();

        if (session()->has("_refU")) {
            $reference = new Reference;
            $reference->referenced_by = session()->get('_refU')["id"];
            $reference->referenced_to  = $member->id;
            $reference->save();
        } else {
            $reference = new Reference;
            $reference->referenced_to = $member->id;
            // check sharing code.
            $r_member = Member::select('id')->where('sharing_code', $request->sharing_code)->first();
            if ($r_member) {
                $reference->referenced_by = $r_member->id;
                $reference->save();
            }
        }
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

        return redirect()->intended(RouteServiceProvider::HOME);
        // return redirect(RouteServiceProvider::HOME);
    }
}
