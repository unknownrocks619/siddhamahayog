<?php
return  [
    "google" => [
        "verification_url" => env("GOOGLE_CAPTCHA_VALIDATION_URL", "https://www.google.com/recaptcha/api/siteverify"),
        "secret_key" => env("GOOGLE_SECRET_KEY"),
        "site_key" => env("GOOGLE_SITE_KEY"),
        "min_score" => env("GOOGLE_MIN_SCORE", .5)
    ]
];
