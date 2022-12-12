<?php

use App\Http\Controllers\Sadhak\MemberJoinController;
use Illuminate\Support\Facades\Route;

Route::prefix('sadhak-portal')
    ->middleware('auth')
    ->name('frontend.sadhak.')
    ->controller(MemberJoinController::class)
    ->group(function () {
        Route::post('/join-as-admin', 'joinAsAdmin')->name('join_as_admin');
        Route::post('/join', 'sadhakJoin')->name('join_as_sadhak');
    });
