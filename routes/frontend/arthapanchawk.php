<?php

use App\Http\Controllers\Frontend\Arthapanchawk\ArthapanchawkController;
use Illuminate\Support\Facades\Route;

Route::prefix('vedanta-philosophy')
    ->controller(ArthapanchawkController::class)
    ->name('vedanta.')
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::middleware("auth")
            ->group(function () {
                Route::get("/signup", 'create')->name('create');
                Route::get("/signup/history", 'createTwo')->name('create_two');
                Route::post("/signup", 'store')->name('store');
                Route::post("/signup/history", 'storeTwo')->name('store_two');
            });
    });
