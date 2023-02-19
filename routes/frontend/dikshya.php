<?php

use App\Http\Controllers\Frontend\Program\DiskhyaController;
use Illuminate\Support\Facades\Route;


Route::prefix('program/dikshya')
    ->name('dikshya.')
    ->controller(DiskhyaController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/store/{set}', 'store')->name('store');
    });
