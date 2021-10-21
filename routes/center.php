<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CentersController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SewasController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\UserReferencesController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\SadhanaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\ZoomController;

/**
 * Admins
 */

Route::get('login',[UserController::class,'center_ad_login'])
        ->name('center_login_index');

Route::post('login',[UserController::class,'verify_login_post'])->name('center_user_login_post');

 Route::post('logout',function(){
     if (Auth::check()){
         Auth::logout();
         return redirect()->route('center_login_index');
     } else{
         abort (404);
     }
 })->name("center_logout");

Route::get('get_user_list',[UserController::class,'get_user_list'])
    ->middleware(['auth','admin'])
    ->name('manager_get_user_list'); // get list of users for select 2 data.

Route::prefix('event')
        ->name('event.')
        ->middleware(['auth','center'])
        ->group( function() {
            Route::get("/zone/{class_id?}",[ZoomController::class,'settings'])->name('center_view_zone_settings');
            Route::get('/zoom/new/settings',[ZoomController::class,'create_settings'])->name('center_zoom_settings_add');
            Route::post('/zoom/save/settings',[ZoomController::class,'store_zoom_settings'])->name('center_store_zoom_setting');
            Route::get('/zoom/zonal-create-meeting/{country}',[ZoomController::class,'create_zonal_meeting'])->name('center_create_zonal_meeting');
            Route::get("/zoom/zonal-registration/{zoom}",[ZoomController::class,"register_participants"])->name('center_create_zonal_registration');
            Route::post('/zoom/zonal_session_start/{zoom}',[ZoomController::class,"start_zonal_session"])->name("center_start_zonal_setting");
            Route::post('/zoom/end_zonal_session/{zoom}',[ZoomController::class,"end_zonal_session"])->name("center_end_zonal_setting");
            Route::get("/zoom/participants/{zoom}",[ZoomController::class,"display_participants"])->name('center_get_participants_list');
            Route::get("/zoom/revoke/{zoom}",[ZoomController::class,"revoke_access"])->name("center_revoke_zoom_access");

        });


/**
 * Users
 */
Route::prefix('users')
        ->name('admin_user.')
        ->group(function () {
        Route::get("login",[UserController::class,'ad_login'])->name('admin_login');
    });

/**
 * Users
 */
Route::name('users.')
        ->middleware(['auth','center'])
        ->group(function () {
            Route::name("sadhak.")
                    ->group(function(){
                    Route::get('registration-enquiries',[SadhanaController::class,"admin_sadahak_registration_list"])->name('sadhak-enquries');
                    Route::get('sadhak-detail/{user}/{type?}',[SadhanaController::class,'show'])->name('sadhak-detail');
                    Route::post('change-sadhak-status/{user}/{type?}',[SadhanaController::class,'change_status'])->name('sadhak-change-status');
            });
});


/**
 * Dashboard
 */

Route::get('dashboard',[DashboardController::class,'ad_dashboard'])
        ->middleware(['center'])    
        ->name('center_dashboard');




Route::prefix('services')
        ->name('center_services.')
        ->middleware(['auth','admin'])
        ->group(function () {
        /**
         * Sewas
        */
        Route::prefix('sewas')
                ->name('sewas.')
                ->group(function(){
                    Route::get('index',[SewasController::class,'index'])->name('center_index');
                    Route::get('form',[SewasController::class,'sewa_form'])->name('center_form');
                    Route::get('delete-form',[SewasController::class,'destroy_form'])->name('center_delete-form');
                    Route::post('delete',[SewasController::class,'destroy'])->name('center_delete');
                    Route::post('submit-new-form',[SewasController::class,'store'])->name('center_submit-new-form');
                    Route::post('update-sewa-service',[SewasController::class,'update_sewa_service'])->name('center_update-sewa-service');
                    Route::post('assign-sewa-to-visitor',[SewasController::class,'assign_visitor_to_sewa'])->name('center_assign-visitor-to-sewa');
                });

        /**
         * Rooms
         */
        Route::prefix('room')
                ->name('room.')
                ->group(function () {
                    Route::get('center_list',[CentersController::class,'index'])->name('center_center_list');
                    Route::get('new_center',[CentersController::class,'new_center_form'])->name('center_new_center_form');
                    Route::post('submit_center_record',[CentersController::class,'create_center'])->name('center_submit_center_record');
                });
});

Route::prefix('rooms')
        ->name('rooms.')
        ->middleware(['auth','admin'])
        ->group(function(){
    Route::get("list",[RoomController::class,'index'])->name('center-room-list');
    Route::get('check-avaibility',[RoomController::class,'check_avaibility'])->name('center-check-avaibility');
    Route::get("add-room",[RoomController::class,'create'])->name('center-add-room');
    Route::get("edit-room/{id}",[RoomController::class,'edit'])->name('center-center-edit-room');
    Route::post("add-room",[RoomController::class,'store'])->name('save-room');
    Route::put('edit-room/{id}',[RoomController::class,'update'])->name('update-room');
    Route::delete('delete-room/{id}',[RoomController::class,'destroy'])->name('delete-room');
});

