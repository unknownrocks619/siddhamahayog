<?php

use App\Http\Controllers\Admin\Website\Settings\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','admin'])
        ->group(function() {
            Route::get("/list", [SettingController::class, "index"])->name("settings.admin_website_settings");
            Route::post('/update', [SettingController::class, "update"])->name('settings.admin_website_update_settings');

        });
