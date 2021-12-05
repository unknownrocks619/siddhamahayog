<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CentersController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomDetailController;
use App\Http\Controllers\SewasController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\EventVideoClassController;
use App\Http\Controllers\OfflineVideoController;
use App\Http\Controllers\ImportExcel;
use App\Http\Controllers\DonationController;

// use App\Http\Controllers\SmsTestController;
/**
 * public
 */
use App\Http\Controllers\General\AccountRecoveryController;
use App\Http\Controllers\General\PublicUserProfileController;
use App\Http\Controllers\General\EngagedEventController;
use App\Http\Controllers\General\GeneralQuestionsController;

/**
 * Rooms
 */
use App\Http\Controllers\General\PublicRoomController;
use App\Http\Controllers\General\PublicEventGroupController;
use App\Http\Controllers\General\PublicEventController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/sms-test',[SmsTestController::class,"index"])->name('sms');
// Route::get('/excel',[ImportExcel::class,'index']);
// Route::get('/import/intl',[ImportExcel::class,'internationList']);
// Route::get("/local/transaction",[ImportExcel::class,'local_transaction'])->name('local_transaction_import');
Route::get('/', function () {
        echo "404 Not Found.";
        die();
    return redirect('locale');
});

Route::prefix('modal')
        ->name('modals.')
        ->middleware(['auth'])
        ->group(function() {
            Route::get('display',[ModalController::class,'modal'])->name('display');
            Route::get('display_modal',[ModalController::class,'modal'])->name('public_modal_display');
});



Route::get('locale',function () {
    return view('public.locale.locale');
});

Route::post('change_locale',function(Request $request){
        if($request->lang == "en") {
            App::setLocale('en');
        } else {
            App::setLocale('np');
        }
    $request->session()->put('locale',App::currentLocale());
    return redirect()->route('sadhana-registration-one');
})->name('set-locale');

Route::get('change_locale_within',function(Request $request) {
    if($request->lang == "en") {
        App::setLocale('en');
    } else {
        App::setLocale('np');
    }
    $request->session()->put('locale',App::currentLocale());
    return back();
})->name('change-language-from');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('login',[UserController::class,'ad_login'])->name('user_login');

});


/**
 * Donations
 */
Route::post('donation',[DonationController::class,'store_sadhak_dontaion'])
        ->middleware(["auth"])
        ->name('donation');

Route::get("/login",[UserController::class,'public_user_login_form'])
        ->name('login');


Route::get('/sadhak-login-form',[UserController::class,'public_user_login_form'])
        ->name('public_user_login');
Route::post('/sadhak-login-form',[UserController::class,'public_login_using_phone'])
        ->name('public_user_login_check');
Route::middleware(["auth"])->get('/p-dashboard',[UserController::class,'public_user_dashboard'])
        ->name('public_user_dashboard');

Route::middleware(['auth'])->post("/p-user/p-logout",function(){
    auth()->guard('web')->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route("public_user_login");
})->name('public_user_logout_button');

Route::middleware(["auth"])
        ->post('/public/class/start',[EventVideoClassController::class,'start'])
        ->name('public_class_start');
Route::middleware(["auth"])
        ->post('/offline_video_update/{v_id}/{a_id}',[OfflineVideoController::class,'public_offline_attendance'])
        ->name('public_offline_video_attendance');



/**
 * 
 */

Route::get("/forgot-password",[AccountRecoveryController::class,'index'])
        ->name('public_forgot_password_form');

Route::post('/forgot-password',[AccountRecoveryController::class,'send_password_reset_link'])
        ->name('public_send_password_link');

Route::get('/recovery',[AccountRecoveryController::class,"verify_password_link"])
        ->name('public_verify_password_link');
Route::post('/confirm-change-password',[AccountRecoveryController::class,'save_change_password'])
        ->name('public_save_change_password');
Route::get('/recovery/sms/',[AccountRecoveryController::class,'verify_password_reset_covery'])
        ->name('public_reset_password_form');
Route::post('/recovery/sms/',[AccountRecoveryController::class,'confirm_reset_password'])
        ->name('public_confirm_reset_password');

Route::prefix("p")
        ->name('public.')
        ->middleware(['auth'])
        ->group (function() {
                // Route::get("profile",[PublicUserProfileController::class,'index'])
                //         ->name('public_profile_display');
                Route::post("profile/personal",[PublicUserProfileController::class,'personal_setting_store'])
                        ->name('public_personal_profile_store');
                Route::post("/profile/password",[PublicUserProfileController::class,'public_change_password'])
                        ->name("public_change_password");
                Route::post('/profile/picture',[PublicUserProfileController::class,'update_profile_picture'])
                        ->name("public_change_profile");
                Route::get("subscription", [EngagedEventController::class,'index'])
                        ->name('public_subscription');
                Route::get('subscription/transaction/{eventId}',[EngagedEventController::class,"transaction_list"])
                        ->name('public_subscription_transaction_list');
                Route::get('subscription/submit-transaction/{event}',[EngagedEventController::class,'add_fund_form'])
                        ->name('public_add_subscription_amount');
                Route::post('subscription/submit-transaction/{event}/online',[EngagedEventController::class,'store_online_payment'])
                        ->name('public_store_subscription_amount_online');
                Route::post('subscription/submit-transaction/{event}/offline',[EngagedEventController::class,'store_offline_payment'])
                        ->name('public_store_subscription_amount_offline');
                
                /**
                 * Exam papers
                 */
                Route::prefix('exam')
                        ->name('exam.')
                        ->group(function() {
                                Route::get("/index",[GeneralQuestionsController::class,'index'])
                                        ->name('public_examination_list');
                                Route::get('/start/{collection}/',[GeneralQuestionsController::class,"start_exam"])
                                        ->name('public_examination_start');
                                Route::post('post/answer/{collection}/{question}',[GeneralQuestionsController::class,"user_answer"])
                                        ->name('public_submit_answer');
                                Route::get("exam/complete/{question}",[GeneralQuestionsController::class,"question_complete"])
                                        ->name('examination_complete');
                });
                
                Route::prefix("room")
                        ->name('room.')
                        ->group(function (){
                                Route::get("/index", [PublicRoomController::class,'index'])
                                        ->name('public_my_room_bookings');
                                Route::get("/bookings/new",[PublicRoomController::class,"create"])
                                        ->name("public_add_new_room_bookings");
                                Route::post('/bookings/check_avaibility',[PublicRoomController::class,"check_avaibility"])
                                        ->name("public_check_room_avaibility");
                                Route::post('/bookings/confirm',[PublicRoomController::class,'confirm_booking'])
                                        ->name('public_confirm_room_booking');
                                Route::post("/bookings/reservation/clear/{reservation_id}",[PublicRoomController::class,'clear_reservation'])
                                        ->name('public_clear_reservation_user');
                                Route::get("/bookings/history",[PublicRoomController::class,"booking_history"])
                                        ->name('public_user_booking_history');
                });
                
                Route::prefix('family')
                        ->name('family.')
                        ->group( function () {
                                Route::get('/list',[PublicEventGroupController::class,"index"])
                                        ->name('public_event_family_list');
                                Route::get("/add/{event?}",[PublicEventGroupController::class,"add_family_to_event"])
                                        ->name('public_add_family_to_event');
                                Route::post('/list/family-members/', [PublicEventGroupController::class,'family_list_search'])
                                        ->name('public_list_family_member');
                                Route::post('/add/{event?}',[PublicEventGroupController::class,"store_family_detail"])
                                        ->name('public_save_family_to_event');
                                Route::post('/remove/leader/{group_id}',[PublicEventGroupController::class,"remove_member"])
                                        ->name('public_remove_user_member_from_group');
                                Route::post('/remove/{group_id}',[PublicEventGroupController::class,"remove_yourself"])
                                        ->name('public_remove_user_yourself_from_group');
                                Route::post("/update/{id}", [PublicEventGroupController::class,"edit_member"])
                                        ->name('public_update_user_detail');
                        });
                
                
                Route::prefix('event')
                        ->name('event.')
                        ->group( function () {
                                Route::post("/group-attendance/{event}",[PublicEventController::class,"group_attendance"])
                                        ->name("public_make_group_attendance");
                                Route::post("/single-attendance/{event}",[PublicEventController::class,"single_attendance"])
                                        ->name("public_make_single_attendance");
                                Route::get('/absent',[PublicEventController::class,"absent"])
                                        ->name('public_list_my_absent_record');
                                Route::post('/abset/{event}',[PublicEventController::class,'absent_search_result'])
                                        ->name("public_list_filter_absent_record");
                                Route::get("/absent/request",[PublicEventController::class,"absent_request_form"])
                                        ->name("public_request_absent_form");
                                Route::post("/absent/request/submit",[PublicEventController::class,"store_absent_request"])
                                        ->name('public_store_request_absent_form');
                                Route::post('absent/list/',[PublicEventController::class,"absent_record"])
                                        ->name('public_display_absent_record');
                                Route::post('/cancel-absent',[PublicEventController::class,"cancel_absent_form"])
                                        ->name('public_request_absent_cancel_form');
                        });

                Route::prefix('offline')
                        ->name('offline.')
                        ->group( function () {
                                Route::get("/list",[PublicEventController::class,'offline_videos'])->name('public_get_offline_videos');
                                Route::get("/list/{sibir_record?}/{video_id?}",[PublicEventController::class,'offline_videos'])->name('public_get_video_detail');
                        });

                Route::prefix("live")
                        ->name('live.')
                        ->group ( function () {
                                Route::get('/list',[PublicEventController::class,'live_program'])->name('public_live_program_list');
                        });
                
                Route::prefix('profile')
                        ->name('profile.')
                        ->group( function() {
                                Route::get('/profile',[PublicUserProfileController::class,'index'])->name('public_profile_display');
                                Route::get("/password",[PublicUserProfileController::class,'password'])->name('public_profile_password');
                                Route::get("/personal",[PublicUserProfileController::class,"personal"])->name("public_personal");
                        });
        });