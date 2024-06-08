<?php

use App\Http\Controllers\Admin\Members\MemberController;
use Illuminate\Support\Facades\Route;

Route::prefix("members")
    ->name('members.')
    ->controller(MemberController::class)
    ->group(function () {

        Route::get("/all", "index")->name('all');
        Route::match(['get','post'],'create','create')->name('create');
        Route::match(['get','post'],'quick-add','quickStore')->name('quick-add');
        Route::post('/partials-validate','memberVerification')->name('member_registration_partials_validate');

        Route::get('/member/detail/{member}/{tab?}', "show")->name("show");
        Route::get("/add/{program?}", "add_member_to_program")->name('admin_add_member_to_program');
        Route::get("/assign/{program}", "assign_member_to_program")->name('admin_add_assign_member_to_program');
        Route::get("/show/program/{member}/{program}", "programShow")->name('admin_show_for_program');
        Route::put('/update-password/{member}', 'updatePassword')->name('admin_change_user_password');
        Route::post('/add/{program?}', "store_member_to_program")->name("admin_store_member_to_program");
        Route::post("/assign/{program}", "store_member_to_class")->name('admin_store_assign_member_to_program');
        Route::post("/show/program/{member}/{emergencyMeta}/{program?}", "programUpdate")->name('admin_update_for_program');
        Route::post("/update/{member}", 'update')->name("admin_update_member_basic_info");
        Route::post("/update/member/meta/{member}/{memberInfo?}", "updatePersonal")->name("admin_update_member_meta_info");
        Route::post("/reauth-as-user/{member}", "reauthUser")->name("admin_login_as_user");
        Route::delete('/delete/{member}', 'deleteUser')->name('admin_user_delete');
        Route::prefix('subscription')
            ->name('subscription.')
            ->controller(MemberController::class)
            ->group(function () {
                Route::post('/cancel/{program}/{member}', 'calcel_subscription')->name('admin_cancel_user_subscription');
            });

        Route::prefix('media/{member}')
                ->group(function() {
                   Route::post('upload',[\App\Http\Controllers\Admin\Members\MemberMediaController::class,'uploadMedia'])
                            ->name('media.upload');
                    Route::post('delete/{relation}',[\App\Http\Controllers\Admin\Members\MemberMediaController::class,'deleteImage'])
                        ->name('media.delete');
                });
    });
