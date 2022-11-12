<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => "1462718610895338",
        'client_secret' => "82f3084908f3c0f0b273625235e4fc64",
        'redirect' => config("app.url") . "/social/login/facebook"
    ],
    'google' => [
        'client_id' => "360712739244-r496klcb4sutfba3j3513g823qsl3t6a.apps.googleusercontent.com",
        'client_secret' => "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",
        'redirect' => config("app.url") . "/social/login/callback/google"
    ],

    'esewa' => [
        'environment' => env("ESEWA_MODE", 'test'),
        "merchant_code" => env("ESEWA_MERCHANT", "EPAYTEST"),
        "redirect_test" => env("ESEWA_REDIRECT_TEST", "https://uat.esewa.com.np/epay/main"),
        "redirect_live" => env("ESEWA_REDIRECT_LIVE", "https://uat.esewa.com.np/epay/main"),
        "verification_test" => env("ESEWA_VERIFICATION_TEST", "https://uat.esewa.com.np/epay/transrec"),
        "verification_live" => env("ESEWA_VERIFICATION_LIVE", "https://uat.esewa.com.np/epay/transrec")
    ]

];
