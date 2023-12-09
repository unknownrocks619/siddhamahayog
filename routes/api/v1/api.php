<?php

use App\Http\Controllers\API\V1\Courses\CourseControllerAPI;
use App\Http\Controllers\API\V1\Member\UserController;
use App\Http\Controllers\API\V1\Programs\ProgramController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')
    ->group(function () {
        Route::prefix('user')
            ->name('user.')
            ->controller(UserController::class)
            ->group(function () {
                Route::post('login', 'autheticate');
            });

        Route::middleware(['auth:sanctum'])
            ->group(function () {
                Route::prefix('programs')
                    ->name('program.')
                    ->controller(ProgramController::class)
                    ->group(function () {
                        Route::get('/enrolled', 'userProgram');
                    });
                Route::prefix('courses')
                    ->name('courses.')
                    ->controller(CourseControllerAPI::class)
                    ->group(function () {
                        Route::get('/lession/{course}/{lessionID?}', 'lession');
                    });
            });
        Route::middleware(['auth'])
            ->group(function () {
                Route::prefix('courses')
                    ->name('courses.')
                    ->controller(CourseControllerAPI::class)
                    ->group(function () {
                        Route::get('/lession/{course}/{lessionID?}', 'lession');
                    });
            });

    });
