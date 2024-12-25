<?php

use App\Http\Controllers\Frontend\User\UserController;
use App\Http\Controllers\Frontend\User\UserConverterController;

Route::prefix('sadhak')
    ->name('conversation.')
    ->group(function () {
        Route::get('start-conversation/{user}', [UserConverterController::class])->name('sadhak.start');
    });

Route::prefix('members')
    ->middleware(['web', 'auth', 'teacher'])
    ->group(function () {

        Route::match(['get', 'post'], "/my-members/{view?}/{teacherCourse?}", [UserController::class, 'myMembers'])->name('user.my-member');
    });
