<?php

use App\Http\Controllers\Admin\Trainings\TrainingController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/trainings')
    ->group(function () {
        Route::get('/list', [TrainingController::class, 'index'])->name('admin.trainings.index');
    });
