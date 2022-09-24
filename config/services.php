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
        'client_id' => "538761618057-u80i30si7qmpp9klb8hl0ioc1g98sht6.apps.googleusercontent.com",
        'client_secret' => "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",
        'redirect' => config("app.url") . "/social/login/google"
    ],

    'esewa' => [
        "merchant_code" => "EPAYTEST",
        "redirect" => "https://uat.esewa.com.np/epay/main",
        "verification" => "https://uat.esewa.com.np/epay/transrec"
    ]

];
