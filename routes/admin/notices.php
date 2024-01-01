<?php

use App\Http\Controllers\Admin\Notice\Noticecontroller;
use Illuminate\Support\Facades\Route;

Route::prefix("notices")
    ->name("notices.")
    ->controller(Noticecontroller::class)
    ->group(function () {
        Route::resource("notice", Noticecontroller::class);
    });
