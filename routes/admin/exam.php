<?php

use App\Http\Controllers\Admin\Exam\ExamController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin/program/{program}')
    ->name('admin.')
    ->group(function () {

        Route::controller(ExamController::class)
            ->prefix('exam-center')
            ->name('exam.')
            ->group(function () {
                Route::get('/', 'index')->name('list');
            });
    });
