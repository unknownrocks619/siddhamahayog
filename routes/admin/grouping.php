<?php

use App\Http\Controllers\Admin\Programs\AdminProgramGroupController;
use Illuminate\Support\Facades\Route;
Route::prefix('grouping/{program}')
        ->group(function(){
            Route::get('list',[AdminProgramGroupController::class,'list'])->name('admin_program_grouping_list');
            Route::match(['get','post'],'list-options',[AdminProgramGroupController::class,'index'])
                ->name('admin_program_grouping_index');
            Route::match(['get','post'],'family-options',[AdminProgramGroupController::class,'familyGroup'])
                ->name('admin_program_grouping_family_index');
            Route::match(['get','post'],'program-student-download',[AdminProgramGroupController::class,'downloadProgramStudent'])
                ->name('admin_program_grouping_family_index');
        });
