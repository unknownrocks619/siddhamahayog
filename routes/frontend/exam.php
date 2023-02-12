<?php

use App\Http\Controllers\Frontend\ExamController;
use Illuminate\Support\Facades\Route;

Route::prefix('{program}/exam')
    ->name('exam.')
    ->controller(ExamController::class)
    ->group(function () {
        Route::get('/list', 'index')->name('list');

        Route::prefix('{exam}')
            ->group(function () {
                Route::get('/overview', 'overview')->name('overview');
                Route::get('/start', 'overview')->name('overview');
            });
    });
