<?php

use App\Http\Controllers\Centers\StudentFeeController;
use App\Http\Controllers\Frontend\Centers\Programs\ProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix("centers/admin")
    ->name('centers.')
    ->middleware(["auth", "center"])
    ->group(function () {
        Route::controller(ProgramController::class)->group(function () {
            Route::get('program/lives', "live")->name('program.live');
            Route::get("program/list", 'index')->name('progmra.list');
        });

        Route::prefix('sadhaks')
            ->group(function () {
                Route::get('/index', ['index'])->name('list');
            });
    });
