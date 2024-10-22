<?php

namespace App\Http\Controllers\API\V1\Member;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function autheticate(LoginRequest $request)
    {
        $request->authenticate();

        if (! $request->post('device')) {
            return response(['message' => 'Failed to retreive device information', 'errors' => ['device' => 'Device information missing']], 401);
        }
        $user = user();

        $user['profile'] = user()->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && user()->profileUrl?->avatar) ? user()->profileUrl->avatar : null);
        return response([
            'errors' => [],
            'message' => "Login Successful !",
            'data' => [
                'Bearer' => user()->createToken($user->getKey() . '_p_token')->plainTextToken,
                'user' => $user,
                'sadhana_level' => [
                    'primary_level' => 0,
                    'secondary_level' => 0,
                ],
                'profile' => user()->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && user()->profileUrl?->avatar) ? user()->profileUrl->avatar : null)
            ]
        ]);
    }

    public function userDetail(Request $request)
    {
        if (! $request->user()) {
            return response([
                'error' => ['Authetication failed.'],
                'message'   => 'Authetication failed',
                'data' => []
            ], 422);
        }
        /** @var Member */
        $user = $request->user();

        return response([
            'errors' => [],
            'message' => "Login Successful !",
            'data' => [
                'Bearer' => str($request->header('Authorization'))->replace('Bearer ', '')->value(),
                'user' => $user,
                'sadhana_level' => [
                    'primary_level' => 0,
                    'secondary_level' => 0,
                ],
                'profile' => user()->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && user()->profileUrl?->avatar) ? user()->profileUrl->avatar : null)
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password'  => 'required',
            'type'  => 'required|in:phone,email',
            'phoneNumber'   => 'required_if:type,phone',
            'email'         => 'required_if:type,email|email',
            'source'        => 'required'
        ]);

        $memberRegistration  = new Member();
        $memberRegistration->fill([
            'first_name'    => ' ',
            'last_name'     => ' ',
            'full_name'     => ' ',
            'source'    =>  $request->post('source'),
            'external_source_id'    => $request->post('device'),
            'password'      => Hash::make($request->post('password')),
            'role_id'       => 7,
        ]);

        if ($request->post('type') == 'phone') {
            $memberRegistration->email = 'random_email_' . uniqid();
            $memberRegistration->allow_username_login = Member::LOGIN_TYPE_PASSWORDLESS;
        } else {

            // check if email already exists.
            if (Member::where('email', $request->post('email'))->exists()) {
                return response(['error' => ['email' => 'Invalid Email.'], 'message' => "Invalid email. Please choose different email.", 'data' => []], 400);
            }

            $memberRegistration->email = $request->post('email');
            $memberRegistration->allow_username_login = Member::LOGIN_TYPE_EMAIL;
            $memberRegistration->save();
        }

        $memberRegistration['profile'] = $memberRegistration->profileImage ?  Image::getImageAsSize(user()->profileImage, 'm') : ((isset(user()->profileUrl->avatar) && $memberRegistration->profileUrl?->avatar) ? $memberRegistration->profileUrl->avatar : null);
        return response([
            'errors' => [],
            'message' => "Login Successful !",
            'data' => [
                'Bearer' => $memberRegistration->createToken($memberRegistration->getKey() . '_p_token')->plainTextToken,
                'user' => $memberRegistration,
                'sadhana_level' => [
                    'primary_level' => 0,
                    'secondary_level' => 0,
                ],
                'profile' => $memberRegistration->profileImage ?  Image::getImageAsSize($memberRegistration->profileImage, 'm') : ((isset($memberRegistration->profileUrl->avatar) && $memberRegistration->profileUrl?->avatar) ? $memberRegistration->profileUrl->avatar : null)
            ]
        ]);
    }
}
