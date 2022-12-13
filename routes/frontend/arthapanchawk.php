<?php

use App\Http\Controllers\Frontend\Arthapanchawk\ArthapanchawkController;
use Illuminate\Support\Facades\Route;


Route::prefix('vedanta-philosophy')
    ->controller(ArthapanchawkController::class)
    ->name('vedanta.')
    ->group(function () {
        Route::get("/", "index")->name("index");
        Route::middleware(['auth'])->group(function () {
            Route::post("/signup", 'store')->name('store');
            Route::get("/signup", 'create')->name('create');
            Route::get("/signup/history", 'createTwo')->name('create_two');
            Route::get('/payment', "payment")->name("payment.create");
            Route::post("/signup/history", 'storeTwo')->name('store_two');
            Route::post("/payment/admission/{program}", "paymentProcessor")->name("payment.store");
            Route::get("/payment/admission/payment/success/{program}", "paymentSuccess")->name("payment.success");
            Route::get("/payment/admission/payment/failed/{program}", "paymentFailed")->name("payment.failed");
        });
    });
