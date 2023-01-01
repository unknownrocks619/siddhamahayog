<?php

use App\Http\Controllers\Admin\Exam\ProgramExamController;

Route::prefix('exam')
    ->name('program.exam.')
    ->controller(ProgramExamController::class)
    ->group(function () {

        Route::get('{program}/list', 'index')->name('list');
        Route::get('/{program}/exam/{exam}/add', 'createQuestions')->name('question.create');
        Route::post('{program}/list', 'store')->name('exam.store');
    });
