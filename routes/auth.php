<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Frontend\ServiceLogin\ServiceLoginController;
use App\Http\Controllers\Frontend\User\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
// Route::get('/login-sadhak', [ServiceLoginController::class, 'sadhakLoginView'])
//     ->middleware('guest')
//     ->name('login');
// Route::get('/login-atirudri', [ServiceLoginController::class, 'atirudriLoginView'])
//     ->middleware('guest')
//     ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/access-code', [AuthenticatedSessionController::class, 'createKey'])
    ->middleware('guest')
    ->name('access_key_create');

Route::post('/access-code', [AuthenticatedSessionController::class, 'storeKey'])
    ->middleware('guest')
    ->name('access_key_store');

/**
 * Allow Join from get Request with special access.
 */
Route::get('login/join-external',[AuthenticatedSessionController::class,'joinUsingExternal'])
        ->name('guest')
        ->name('access_login');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post("/login/redirect/facebook", function () {
    return Socialite::driver('facebook')->redirect();
})->name("social_login_redirect");

Route::post("/login/redirect/gmail", function () {
    return Socialite::driver('google')->redirect();
})->name("social_login_redirect_google");

Route::get("/social/login/{ref}", [UserController::class, "facebook"])->name("social_login_callback");
Route::get("/social/login/callback/google", [UserController::class, "google"])->name("social_login_callback_google");
