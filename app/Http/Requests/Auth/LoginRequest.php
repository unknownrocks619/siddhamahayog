<?php

namespace App\Http\Requests\Auth;

use App\Models\Member;
use App\Models\User;
use App\Rules\GoogleCaptcha;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_user' => ['required', 'string'],
            'password' => ['required', 'string'],
            // "recaptcha_token" => ["required", new GoogleCaptcha()]
        ];
    }

    public function messages()
    {
        return [
            "recaptcha_token.required" => "Invalid Google Captcha. Please try again.",
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $auth = [
            'email' => $this->post('email_user'),
            'password' => $this->post('password')
        ];

        if (!Auth::attempt($auth, $this->boolean('remember'))) {

            // try with username.
            $username  = [
                'username' => $auth['email'],
                'password'  => $auth['password']
            ];

            if (! Auth::attempt($username, $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            } else {

                if (! auth()->check()) {
                    RateLimiter::hit($this->throttleKey());
                    throw ValidationException::withMessages([
                        'email' => __('auth.failed'),
                    ]);
                } else {
                    $user = auth()->user();

                    if ($user->allow_username_login !== true) {
                        auth()->logout();
                        RateLimiter::hit($this->throttleKey());
                        throw ValidationException::withMessages([
                            'email' => __('auth.failed'),
                        ]);
                    }
                }
            }
        }
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return $this->ip();
    }
}
