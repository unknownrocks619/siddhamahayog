<?php

use App\Http\Controllers\Admin\FileManager\AdminFileManagerController;
use App\Http\Controllers\Admin\Programs\ProgramCourseResourceController;
use Illuminate\Support\Facades\Route;

Route::prefix("resources")
->name('resources.')
->group(function () {
    Route::get('/program/edit/{course}', [ProgramCourseResourceController::class, "edit_doc_by_program"])->name('admin_edit_course_resource');
    Route::get("/delete", [AdminFileManagerController::class, "delete_resource"])->name("admin_delete_resource");
    Route::prefix('videos')
        ->name('videos.')
        ->group(function () {
        });
    Route::prefix('doc')
        ->name('doc.')
        ->group(function () {

            Route::get('/list/program/{program}', [AdminFileManagerController::class, "doc_by_program"])->name('admin_doc_by_program');
        });

    Route::post('/program/update/{resource}', [ProgramCourseResourceController::class, "update_program_resource"])->name("admin_update_course_resource");
});