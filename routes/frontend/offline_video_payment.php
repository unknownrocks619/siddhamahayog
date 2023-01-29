<?php

Route::prefix('payment/{video}')
    ->name('frontend.offline.payment.')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/',)->name('create');
    });
