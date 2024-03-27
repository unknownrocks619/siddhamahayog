<?php

use App\Http\Controllers\Admin\Programs\AdminProgramController;
use App\Http\Controllers\Admin\Programs\AdminProgramGroupController;
use Illuminate\Support\Facades\Route;
Route::prefix('grouping/{program}')
        ->group(function(){
            Route::get('list',[AdminProgramGroupController::class,'list'])->name('admin_program_grouping_list');
            Route::match(['get','post'],'create',[AdminProgramGroupController::class,'create'])->name('admin_program_group_create');
            Route::match(['get','post'],'edit/{group}/{tab?}',[AdminProgramGroupController::class,'edit'])->name('admin_program_group_edit');
            Route::get('{group}/generate-id-card/{people}',[AdminProgramGroupController::class,'generateIDCard'])->name('admin_program_generate_card');

            Route::match(['get','post'],'list-options',[AdminProgramGroupController::class,'index'])
                ->name('admin_program_grouping_index');
            Route::match(['get','post'],'family-options',[AdminProgramGroupController::class,'familyGroup'])
                ->name('admin_program_grouping_family_index');
            Route::match(['get','post'],'program-student-download',[AdminProgramGroupController::class,'downloadProgramStudent'])
                ->name('admin_program_grouping_family_index');

            Route::match(['get','post'],'update-family-group/{group}/{people}',[AdminProgramGroupController::class,'updateFamilyGroup'])
                ->name('admin_update_family_group');
            Route::match(['get','post'],'add-family-group/{group}/{people}',[AdminProgramGroupController::class,'addFamilyGroup'])
                ->name('admin_add_family_group');
            Route::match(['get','post'],'update-dharmasala/{group}/{people}',[AdminProgramGroupController::class,'updateDharamasaBooking'])
                ->name('admin_group_dharamasal');

        });
