<?php

use App\Http\Controllers\API\V1\Courses\CourseControllerAPI;
use App\Http\Controllers\API\V1\Member\UserController;
use App\Http\Controllers\API\V1\Programs\ProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->group(function () {
        Route::prefix('user')
            ->group(function () {
                Route::post('login', [UserController::class, 'authenticate'])->name('user.login');
                Route::post("register", [UserController::class, 'register'])->name('user.register');
                Route::post('register/{process}', [UserController::class, 'registerAccount'])->name('user.registration-process');
                Route::post('registration-token', [UserController::class, 'registrationToken'])->name('user.register-token');
                Route::post('resend-otp', [UserController::class, 'resendOTP'])->name('user.resend-otp');
                Route::post('verify-otp', [UserController::class, 'verifyOTP'])->name('user.verify-otp');
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
