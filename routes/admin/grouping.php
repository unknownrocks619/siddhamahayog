<?php

use App\Http\Controllers\Admin\Programs\AdminProgramController;
use App\Http\Controllers\Admin\Programs\AdminProgramGroupController;
use Illuminate\Support\Facades\Route;
Route::prefix('grouping/{program}')
        ->group(function(){
            Route::get('list',[AdminProgramGroupController::class,'list'])->name('admin_program_grouping_list');
            Route::match(['get','post'],'create/{group?}',[AdminProgramGroupController::class,'create'])->name('admin_program_group_create');
            Route::match(['get','post'],'edit/{group}/{tab?}/{parentGroup?}',[AdminProgramGroupController::class,'edit'])->name('admin_program_group_edit');
            Route::get('edit-ajax/{group}/{view}',[AdminProgramGroupController::class,'editAjax'])->name('admin_program_group_edit_view');
            Route::get('{group}/generate-id-card/{people}/{reset?}',[AdminProgramGroupController::class,'generateIDCard'])->name('admin_program_generate_card');

            Route::post('delete-group/{group}',[AdminProgramGroupController::class,'deleteGroup'])
                ->name('admin_program_group_delete');

            Route::match(['get','post'],'list-options',[AdminProgramGroupController::class,'index'])
                ->name('admin_program_grouping_index');
            Route::match(['get','post'],'family-options',[AdminProgramGroupController::class,'familyGroup'])
                ->name('admin_program_grouping_family_index');
            Route::match(['get','post'],'program-student-download',[AdminProgramGroupController::class,'downloadProgramStudent'])
                ->name('admin_program_grouping_family_index');

            Route::match(['get','post'],'update-family-group/{group}/{people}/{view?}',[AdminProgramGroupController::class,'updateFamilyGroup'])
                ->name('admin_update_family_group');
            Route::match(['get','post'],'add-family-group/{group}/{people}/{view?}',[AdminProgramGroupController::class,'addFamilyGroup'])
                ->name('admin_add_family_group');
            Route::match(['get','post'],'update-dharmasala/{group}/{people}',[AdminProgramGroupController::class,'updateDharamasaBooking'])
                ->name('admin_group_dharamasal');

            Route::get('{group}/view-card/{people?}',[AdminProgramGroupController::class,'viewCard'])
                ->name('amdmin_group_card_view');
            
            Route::match(['get','post'],'{group}/updateVerification/{people}',[AdminProgramGroupController::class,'updateVerification'])
                ->name('admin_people_verification');

            Route::get('search-group-member/{group}',[AdminProgramGroupController::class,'searchGroupMember'])
                ->name('admin_grouping_member_list');
            
            Route::post('add-member-to-group/{group}',[AdminProgramGroupController::class,'addMemberToGroup'])
                ->name('admin_add_member_to_group');

    });
