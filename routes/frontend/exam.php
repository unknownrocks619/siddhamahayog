<?php

use App\Http\Controllers\Frontend\Exams\ExamCenterController;
use App\Http\Controllers\Frontend\Exams\ResultController;
use Illuminate\Support\Facades\Route;

Route::prefix('{program}/exam')
    ->name('exam.')
    ->controller(ExamCenterController::class)
    ->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::prefix('{exam}')
            ->group(function () {
                Route::get('/overview', 'overview')->name('overview');
                Route::get('/start', 'start')->name('start');
                Route::post('/start/{question?}', 'getQuestion')->name('fetch-start');
                Route::post('/save-answer/{question}', 'saveAnswer')->name('save-answer');
            });
    });

/**
 * Result
 */
Route::prefix("/result")
    ->name('result.')
    ->controller(ResultController::class)
    ->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/view/{exam}/{result}/view', 'index')->name('view');
        Route::get('/{exam}/{result}/download', 'download')->name('download');
    });
