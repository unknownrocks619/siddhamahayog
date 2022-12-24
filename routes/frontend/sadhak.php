<?php

use App\Http\Controllers\Frontend\User\UserConverterController;

Route::prefix('sadhak')
    ->name('conversation.')
    ->group(function () {
        Route::get('start-conversation/{user}', [UserConverterController::class])->name('sadhak.start');
    });
