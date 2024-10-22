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
                Route::post("register", 'register');
            });

        Route::middleware(['auth:sanctum'])
            ->group(function () {
                Route::prefix('programs')
                    ->name('program.')
                    ->controller(ProgramController::class)
                    ->group(function () {
                        Route::get('/enrolled', 'userProgram');
                        Route::get('/live', 'livePrograms');
                        Route::match(['get', 'post'], '/live-join', 'joinSession');
                    });
                Route::prefix('courses')
                    ->name('courses.')
                    ->controller(CourseControllerAPI::class)
                    ->group(function () {
                        Route::get('/lession/{course}/{lessionID?}', 'lession');
                    });

                Route::prefix('user')->group(function () {
                    Route::match(['get', 'post'], 'detail', [UserController::class, 'userDetail']);
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
        Route::middleware(['auth', 'admin'])
            ->group(function () {
                Route::prefix('dharmasala')
                    ->group(function () {
                        Route::get('/building');
                    });
            });
    });
