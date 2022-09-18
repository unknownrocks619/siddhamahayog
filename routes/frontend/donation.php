<?php

use App\Http\Controllers\Frontend\Donation\DonationController;
use Illuminate\Support\Facades\Route;

Route::prefix("donations")
    ->name("donations.")
    ->middleware(["auth"])
    ->controller(DonationController::class)
    ->group(function () {
        Route::post('/donation/{serviceProvider}', "donate")->name('donate');
        Route::get("/donation/{serviceProvider}/success", "success")->name('success');
        Route::get("/donation/{serviceProvider}/failed", "failed")->name('failed');
        Route::get('/donation/list/dashboard', "ajaxDonationHistory")->name("dashboard");
    });
