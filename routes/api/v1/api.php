<?php

use App\Http\Controllers\API\V1\Member\UserController;
use App\Http\Controllers\API\V1\Programs\ProgramController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/user')
    ->name('user.')
    ->controller(UserController::class)
    ->group(function () {
        Route::post('login', 'autheticate');
    });

Route::prefix('v1/programs/')
    ->middleware(['auth:sanctum'])
    ->name('program.')
    ->controller(ProgramController::class)
    ->group(function () {
        Route::get('/enrolled', 'userProgram');
    });
