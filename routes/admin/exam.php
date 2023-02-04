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
                Route::get('/edit/{exam}', 'editPrimaryQuestion')->name('edit-primary-question');
                Route::get('/edit-form', 'editForm')->name('edit-form');
                Route::get('/{exam}/edit/', 'edit')->name('edit');
                Route::get('/question/{question}/edit/', 'editQuestion')->name('question.edit');
                Route::post('/', 'store')->name('store');
                Route::post('/question/{question}/edit/', 'updateQuestion')->name('question.update');
                Route::post('/question/{exam}', 'storeQuestions')->name('store.question');
                Route::delete('/exam/question/delete/{question}', 'deleteQuestion')->name('remove.question');
                Route::delete('/delete/primary-question/{exam}', 'deletePrimaryQuestion')->name('delete-primary-question');
                Route::put('update/primary-question/{exam}', 'updatePrimaryQuestion')->name('udpate-primary-question');
            });
    });
