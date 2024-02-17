<?php

use Illuminate\Support\Facades\Route;

Route::prefix('center')
        ->middleware(['web','center'])
        ->group(function() {
            Route::get('/dashboard');
        });