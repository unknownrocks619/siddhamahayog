<?php

use App\Http\Controllers\Frontend\Donation\DonationController;
use Illuminate\Support\Facades\Route;

Route::prefix("donations")
    ->name("donations.")
    ->middleware(["auth"])
    ->controller(DonationController::class)
    ->group(function () {
        Route::get('/donation/list', 'index')->name('list');
        Route::get('/donation/page/{serviceProvider}', "donate")->name('donate_get');
        Route::post('/donation/page/{serviceProvider}', "donate")->name('donate_post');
        Route::get("/donation/{serviceProvider}/success", "success")->name('success');
        Route::get("/donation/{serviceProvider}/failed", "failed")->name('failed');
        Route::get('/donation/list/dashboard', "ajaxDonationHistory")->name("dashboard");
        Route::post('/donation/{serviceProvider}', "donate")->name('donate');
        Route::post('/donation/{serviceProvider}/payment', 'processPayment')->name('donation_process');
    });
