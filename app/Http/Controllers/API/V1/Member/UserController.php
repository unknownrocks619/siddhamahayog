<?php

namespace App\Http\Controllers\API\V1\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function autheticate(Request $request)
    {
        $request->validate([
            'email' => "required|email",
            'password' => "required",
            'device' => 'required'
        ]);

        $member = Member::where('email', $request->post('email'))->first();

        if (!$member || !Hash::check($request->post('password'), $member->password)) {
            return response(['errors' => ['email' => ['The provided credentials are incorrect.']]], 422);
        }

        return response(['errors' => [], 'message' => "Login Successful !", 'data' => ['Bearer' => $member->createToken($request->post('device'))->plainTextToken]]);
    }
}
