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
use App\Http\Controllers\EventVideoClassController;
use App\Http\Controllers\OfflineVideoController;
use App\Http\Controllers\Admin\ZoomController;
use App\Http\Controllers\Admin\Chapters\ChapterCourseController;
/**
 * Admin Folder Controller
 */
use App\Http\Controllers\Admin\QuestionCollectionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionEvaulateController;
use App\Http\Controllers\Admin\ZoomActionController;
use App\Http\Controllers\Admin\CourseController;
/**
 * Admins
 */

Route::get('login',[UserController::class,'ad_login'])
        ->middleware(['guest'])
        ->name('admin_login_index');
Route::post('login',[UserController::class,'verify_login_post'])->name('user_login_post');

 Route::post('logout',function(){
     if (Auth::check()){
         Auth::logout();
         return redirect()->route('admin_login_index');
     } else{
         abort (404);
     }
 })->name("logout");

Route::get('get_user_list',[UserController::class,'get_user_list'])
    ->middleware(['auth','admin'])
    ->name('get_user_list'); // get list of users for select 2 data.


Route::prefix('modal')
        ->name('modals.')
        ->middleware(['auth','admin'])
        ->group(function() {
            Route::get('display',[ModalController::class,'modal'])->name('display');
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
        ->middleware(['auth','admin'])
        ->group(function () {
            Route::get('register',[UserController::class,'new_user'])->name('new_user_registration');
            Route::get("edit/{userDetail}",[UserController::class,'edit'])->name('edit_user_detail');
            Route::put('edit/{userDetail}',[UserController::class,'update'])->name('update_user_detail');
            Route::get('user-list',[UserController::class,'index'])->name('user-list');
            Route::get('user-detail/{id}',[UserController::class,'ad_user_detail'])->name('view-user-detail');
            Route::get("user-detail/{id}/{type}",[UserController::class,'ad_user_detail'])->name('view-service-detail');

            Route::name("sadhak.")
                    ->group(function(){
                    Route::get('sadhak/registration-enquiries',[SadhanaController::class,"admin_sadahak_registration_list"])->name('sadhak-registration');
                    Route::get('sadhak/sadhak-detail/{user}/{type?}',[SadhanaController::class,'show'])->name('admin-sadhak-detail');
                    Route::get('sadhak/index',[SadhanaController::class,'index'])->name('list');
                    Route::get('sadhak/add-sibir-record',[SadhanaController::class,'sibir_add_form'])->name('add');
                    Route::get('sadhak/edit-sibir-record/{sibir}',[SadhanaController::class,'sibir_edit_form'])->name('edit');
                    Route::get('/sadhak/report/{sibir}',[SadhanaController::class,'report'])->name('sadhak-report');
                    Route::get("/sadhak/report/{sibir}/list",[SadhanaController::class,'participants_list'])->name('admin_user_view_sibir_participants');
                    Route::get("/sadhak/report/{sibir}/attendance",[SadhanaController::class,'sibir_attendance'])->name('admin_sadhak_attendance_view');
                    Route::get("/sadhak/group/list",[SadhanaController::class,'user_group_list'])->name('admin_user_group_list');
                    Route::get("/sadhak/absent",[SadhanaController::class,'absent_request'])->name("admin_absent_filter_view");
                    Route::get("/sadha/absent/status",[SadhanaController::class,'change_absent_record'])->name("admin_change_absent_status");
                    Route::post('/sadhak/display_absent_result',[SadhanaController::class,"absent_filter_show"])->name('admin_absent_filter_record_view');
                    Route::post("/sadhak/group/list",[SadhanaController::class,'group_filter_view'])->name('admin_user_group_list_filter');
                    Route::post('/sadhak/group/{status}/{sibir}/{leader}',[SadhanaController::class,'change_group_status'])->name('admin_change_group_request_status');
                    Route::post('/sadhak/group/remove/{member_id}',[SadhanaController::class,'remove_member_from_list'])->name('admin_remove_user_from_group');
                    Route::post('sadhak/change-sadhak-status/{user}/{type?}',[SadhanaController::class,'change_status'])->name('sadhak-change-status');
                    Route::post('sadhak/add-sibir-record',[SadhanaController::class,'save_sibir_form'])->name('submit-form');
                    Route::post('sadhak/edit-sibir-record/{sibir}',[SadhanaController::class,'update_sibir_form'])->name('update_sibir_record');
                    Route::post('sadhak/update-status/{sibir}',[SadhanaController::class,'close_sibir_record'])->name('update_sibir_status');
                    
            });

            Route::post('submit_registration',[UserController::class,'submit_registration'])->name('submit_registration');
            Route::post('user_verification_registration',[UserController::class,'submit_user_verification'])->name('submit_user_verification');
            Route::post('user_webcam_upload',[UserController::class,'store_webcam_upload'])->name('store_webcam_upload');
            Route::post('user_references',[UserController::class,'save_sewa_reference'])->name('user-reference');
            Route::post('add_new_email',[UserController::class,'store_new_email'])->name('add_new_email');
            Route::post("update_pet_name",[UserController::class,'update_pet_name'])->name('update_pet_name');
            Route::post('update_marital_stat',[UserController::class,'update_marital_status'])->name('update_marital_stat');

            Route::name('user_reference.')
                    ->group( function () {
                        Route::post('update-references',[UserReferencesController::class,'update_user_references'])->name('update-reference');
            });

            Route::name('user_verification.')
                    ->group( function() {
                        Route::post('update',[UserVerificationController::class,'update'])->name('update_verfication');
            });
});


/**
 * Dashboard
 */

Route::get('dashboard',[DashboardController::class,'ad_dashboard'])
        ->middleware(['admin'])    
        ->name('admin_dashboard');

/**
 * Bookings
 */

Route::prefix('bookings')
        ->name('bookings.')
        ->middleware(['auth','admin'])
        ->group(function () {
            Route::get('list',[BookingController::class,'index'])->name('booking-list');
            Route::get('add',[BookingController::class,'create'])->name('ad-new-booking');
            Route::post('add',[BookingController::class,'store'])->name('ad-store-booking');
            Route::put('check-out-user/{booking}',[BookingController::class,'update'])->name('check-out-user');
        });
        
/**
 * Centers
 */
Route::prefix('centers')
        ->name('centers.')
        ->middleware(['auth','admin'])
        ->group(function () {
            Route::get('center_list',[CentersController::class,'index'])->name('center_list');
            Route::get('new_center',[CentersController::class,'new_center_form'])->name('new_center_form');
            Route::post('submit_center_record',[CentersController::class,'create_center'])->name('submit_center_record');
        });

Route::prefix('services')
        ->name('services.')
        ->middleware(['auth','admin'])
        ->group(function () {
        /**
         * Sewas
        */
        Route::prefix('sewas')
                ->name('sewas.')
                ->group(function(){
                    Route::get('index',[SewasController::class,'index'])->name('index');
                    Route::get('form',[SewasController::class,'sewa_form'])->name('form');
                    Route::get('delete-form',[SewasController::class,'destroy_form'])->name('delete-form');
                    Route::post('delete',[SewasController::class,'destroy'])->name('delete');
                    Route::post('submit-new-form',[SewasController::class,'store'])->name('submit-new-form');
                    Route::post('update-sewa-service',[SewasController::class,'update_sewa_service'])->name('update-sewa-service');
                    Route::post('assign-sewa-to-visitor',[SewasController::class,'assign_visitor_to_sewa'])->name('assign-visitor-to-sewa');
                });

        /**
         * Rooms
         */
        Route::prefix('room')
                ->name('room.')
                ->group(function () {
                    Route::get('center_list',[CentersController::class,'index'])->name('center_list');
                    Route::get('new_center',[CentersController::class,'new_center_form'])->name('new_center_form');
                    Route::post('submit_center_record',[CentersController::class,'create_center'])->name('submit_center_record');
                });
});

Route::prefix('rooms')
        ->name('rooms.')
        ->middleware(['auth','admin'])
        ->group(function(){
            Route::get("list",[RoomController::class,'index'])->name('room-list');
            Route::get('check-avaibility',[RoomController::class,'check_avaibility'])->name('check-avaibility');
            Route::get("add-room",[RoomController::class,'create'])->name('add-room');
            Route::get("edit-room/{id}",[RoomController::class,'edit'])->name('edit-room');
            Route::post("add-room",[RoomController::class,'store'])->name('save-room');
            Route::put('edit-room/{id}',[RoomController::class,'update'])->name('update-room');
            Route::delete('delete-room/{id}',[RoomController::class,'destroy'])->name('delete-room');
});


Route::prefix("event")
        ->name("events.")
        ->middleware(["auth",'admin'])
        ->group( function() {
            Route::get('/class',[EventVideoClassController::class, 'index'])
            ->name('admin_video_class_list');
            Route::get('/class/new',[EventVideoClassController::class,'create'])
            ->name('admin_video_add_form');
            Route::post('/class/save',[EventVideoClassController::class,'store'])
            ->name('admin_video_save');
            Route::post('/class/start',[EventVideoClassController::class,'start'])
            ->name('admin_video_start');
            Route::post("/class/end",[EventVideoClassController::class,'end_class'])
            ->name('admin_video_end');
            Route::get('/class/active_attendance/{event}',[EventVideoClassController::class,'view_active_attendance'])
            ->name('admin_view_active_attendance');
            Route::get('/class/session/{event}',[EventVideoClassController::class,'view_session'])
            ->name('admin_view_active_session');
            Route::get('/class/session/attendance/{log_id}',[EventVideoClassController::class,'view_session_attendance'])
            ->name('admin_view_session_attendance');
            
            /**
             * zone settings.
             */

             Route::prefix('zoom')->name('zoom.')
             ->group(function() {
                Route::get("other/meeting/",[ZoomController::class,"list_general_meetings"])->name("admin_zoom_other_general_settings");
                Route::post("other/create/",[ZoomController::class,"create_meeting_for_other"])->name("admin_zoom_create_other_meetings");
                Route::post('other/start/meeting/',[ZoomController::class,"start_other_meeting_for_detail"]);
    
             });

            Route::get("/zone/{class_id?}",[ZoomController::class,'settings'])->name('admin_view_zone_settings');
            Route::get('/zoom/new/settings',[ZoomController::class,'create_settings'])->name('admin_zoom_settings_add');
            Route::post('/zoom/save/settings',[ZoomController::class,'store_zoom_settings'])->name('admin_store_zoom_setting');
            Route::get('/zoom/zonal-create-meeting/global',[ZoomController::class,'create_global_meeting'])->name('admin_create_global_meeting');
            Route::get("/zoom/participants/{zoom}",[ZoomController::class,"display_participants"])->name('admin_get_participants_list');
            Route::get('/zoom/zonal-create-meeting/{country}',[ZoomController::class,'create_zonal_meeting'])->name('admin_create_zonal_meeting');
            Route::get("/zoom/zonal-registration/{zoom}",[ZoomController::class,"register_participants"])->name('admin_create_zonal_registration');
            Route::get("/zoom/revoke/{zoom}",[ZoomController::class,"revoke_access"])->name("admin_revoke_zoom_access");
            Route::get("/zoom/merge/",[ZoomController::class,"zoom_merge"])->name("admin_view_merge_session");
            Route::get("/zoom/registration/{zoom}",[ZoomController::class,"global_sadhak_register"])->name('admin_register_participants_to_sibir');
            Route::get("/zoom/reconnect/{zoom}",[ZoomController::class,"reconnect_session"])->name('admin_reconnect_zoom_session');
            Route::get("/zoom/join/{zoom}",[ZoomController::class,'admin_join_as_sadhak'])->name('admin_zoom_join_as_sadhak');
            Route::post("/zoom/merge/post",[ZoomController::class,"merge_submission"])->name("admin_merge_session");
            Route::post('/zoom/zonal_session_start/{zoom}',[ZoomController::class,"start_zonal_session"])->name("admin_start_zonal_setting");
            Route::post('/zoom/end_zonal_session/{zoom}',[ZoomController::class,"end_zonal_session"])->name("admin_end_zonal_setting");
            Route::post("/zoom/global-session-start/{zoom}",[ZoomController::class,'start_global_session'])->name('admin_start_global_meeting');
            Route::post('/zoom/global-session-end/{zoom}',[ZoomController::class,"end_global_session"])->name("admin_end_global_setting");
            Route::post("/zoom/registration/remove/{zoom}",[ZoomController::class,'global_remove_registration'])->name('admin_remove_global_registered_user');
            Route::post('/zoom/add-user/',[ZoomController::class,'add_user_to_meeting'])->name('admin_add_user_to_meeting');
            
            /**
             * for General Meeting and other settings.
             */


            Route::get('/video',[OfflineVideoController::class,'index'])
                ->name('admin_offline_video_list');
            Route::get("/video/add",[OfflineVideoController::class,"create"])
                ->name('admin_offline_video_add');
            Route::post('/video/add',[OfflineVideoController::class,'store'])
                ->name('admin_offline_video_save');
            Route::post('/video/edit/{video}',[EventVideoClassController::class,'edit_video'])
                ->name('admin_offline_video_edit');
            Route::get("/video/change_status/{video}",[OfflineVideoController::class,"update_status"])
                ->name('admin_update_only_offline_video_status');
            Route::get("/video/attendances/{video}",[OfflineVideoController::class,"attendance_list"])
                ->name('admin_offline_video_attendance_list');
            Route::get('/revoke_live_class',[EventVideoClassController::class,'revoke_access'])
                ->name("admin_revoke_class_attendance");
            
        });


Route::prefix("questions")
    ->name('questions.')
    ->middleware(['auth','admin'])
    ->group(function() {

        Route::get('/list',[QuestionController::class,"index"])
            ->name('admin_list_questions');
        Route::get("/add",[QuestionController::class,'add_questions'])
            ->name('admin_add_questions');
        Route::post('/add',[QuestionController::class,'store_question'])
            ->name('admin_save_questions_store');
        Route::post('question/update/{question}',[QuestionController::class,'update_question'])
            ->name('admin_update_question');
        Route::get('question/delete/{question}', [QuestionController::class,'delete_question'])
            ->name('admin_question_delete');


        Route::get("/collection",[QuestionCollectionController::class,'index'])
            ->name('admin_question_collection_list');
        Route::get('/collection/add',[QuestionCollectionController::class,'create'])
            ->name('admin_add_question_collection');
        Route::get("/collection/edit/{collection}",[QuestionCollectionController::class,'edit'])
            ->name('admin_edit_question_collection');

        Route::post("collection/add",[QuestionCollectionController::class,'store'])
            ->name('admin_save_question_collection');
        Route::post("collection/edit/{collection}",[QuestionCollectionController::class,'update'])
            ->name('admin_update_question_collection');
        Route::delete('/collection/remove/{delete}',[QuestionCollectionController::class,'destroy'])
            ->name('admin_remove_collection');

        Route::get('/exam/evaluate',[QuestionEvaulateController::class,'index'])
            ->name('admin_evaluate_form');
        
        Route::get("/exam/manual-eval",[QuestionEvaulateController::class,'manual_eval'])
            ->name('admin_manual_evaluate');
        Route::get("/exam/manu-eval-options",[QuestionEvaulateController::class,'eval_form'])
            ->name('admin_eval_selection');
        Route::post("/exam/subjective_marks",[QuestionEvaulateController::class,'save_subjective_marks'])
            ->name('admin_subjective_marks_submit');
});

Route::prefix("course")
        ->name("courses.")
        ->middleware(["auth","admin"])
        ->group( function() {
                Route::get("/list",[CourseController::class,"index"])->name('admin_course_list');
                Route::get("/add",[CourseController::class,"create"])->name("admin_course_add");
                Route::get("/report/{course}",[CourseController::class,'course_report'])->name("admin_course_report");
                Route::get("/payment/unverified/datatable", [CourseController::class,"unverified_payment_datatable_view"])->name('admin_unverified_list_datatable');
                Route::get("/payment/verification/{course?}",[CourseController::class,"unverified_payments"])->name("admin_payment_verification");
                Route::get("/payment/status/{transaction}",[CourseController::class,"change_payment_status"])->name("admin_change_payment_status");
                Route::post("/payment/status/{transaction}",[CourseController::class,"store_change_payment_status"])->name('admin_store_change_payment_status');
                Route::get("/payment/overdue",[CourseController::class,"overdue_view"])->name('admin_payment_overdue');
                Route::post("/payment/overdue/report",[CourseController::class,"overdue_report"])->name('admin_payment_overdue_report');
                Route::get("/paymnet/transaction/report/view/{transaction}",[CourseController::class,'transaction_detail'])->name("admin_view_transaction_detail");
                Route::get("/payment/add",[CourseController::class,"add_payment"])->name('admin_add_payment_detail');
                Route::post("/payment/add",[CourseController::class,"store_payment"])->name("admin_save_payment_detail");
                Route::get("/report/generate/{course}",[CourseController::class,"generate_report"])->name('admin_course_generate_report');
                Route::post("/add",[CourseController::class,"store"])->name("admin_course_store");
        });


    Route::get('/attendance', function (){
     return view("admin.attendance.report");
    });

Route::get("/user-registration-link", [ZoomActionController::class,"index"])->name("admin_zoom_registration_view");
Route::get('/user-generate-link/{meetin_id}/{user_id?}',[ZoomActionController::class,"generate_link"])->name('admin_generate_link');

Route::prefix('chapters')
        ->name('chapters.')
        ->middleware(['auth','admin'])
        ->group(function() {
            Route::get("/list",[ChapterCourseController::class,'index'])->name("admin_list_all_chapters");
            Route::get('/add',[ChapterCourseController::class,"create"])->name('admin_add_new_chapters');
            Route::get('/edit/{courseChapter}',[ChapterCourseController::class,"edit"])->name('admin_edit_chapter_detail');
            Route::post('/add',[ChapterCourseController::class,"store"])->name("admin_store_chapter");
            Route::post('/edit/{courseChapter}',[ChapterCourseController::class,"update"])->name('update_chapter_detail');

            Route::prefix('lession')
                    ->name('lession.')
                    ->group( function () {
                        Route::get("/list/{courseChapter}",[ChapterCourseController::class,"show"])->name("admin_course_videos");
                        Route::get('/add/{courseChapter}',[ChapterCourseController::class,"add_video"])->name('admin_course_add_video');
                        Route::post("/add/{courseChapter}",[ChapterCourseController::class,"store_video"])->name('admin_store_new_video');
                        Route::get("/edit/{video}",[ChapterCourseController::class,"edit_video"])->name("admin_edit_offline_video");
                        Route::post('/edit/{video}',[ChapterCourseController::class,"update_video"])->name("admin_update_offline_video");
                    });
        });