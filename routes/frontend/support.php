<?php

use App\Http\Controllers\Support\SupportStaffController;
use Illuminate\Support\Facades\Route;

Route::prefix("staff/support")
    ->middleware(['auth', 'auth.support'])
    ->name('supports.staff.')
    ->group(function () {
        Route::resource('tickets', SupportStaffController::class);
    });
