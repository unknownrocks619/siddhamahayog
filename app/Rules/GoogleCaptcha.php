<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class GoogleCaptcha implements Rule
{
    private $_verification_url = null;
    private $_secret_key = null;
    private $_site_key = null;
    private $_min_score = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->_verification_url = "https://www.google.com/recaptcha/api/siteverify";
        $this->_secret_key = config('captcha.google.secret_key');
        $this->_site_key = config('captcha.google.site_key');
        $this->_min_score = config('captcha.google.min_score');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $response = Http::asForm()->post($this->_verification_url, [
            'secret' => $this->_secret_key,
            'response' => $value,
            'ip' => request()->ip(),
        ]);
        if ($response->successful() && $response->json("success") && $response->json('score') > $this->_min_score) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Captcha validation failed.';
    }
}
