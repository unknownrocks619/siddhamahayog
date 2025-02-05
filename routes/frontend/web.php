<?php

use App\Http\Controllers\API\V1\Courses\CourseControllerAPI;
use App\Http\Controllers\API\V1\Member\UserController;
use App\Http\Controllers\Dharmashala\DharmashalaController;
use App\Http\Controllers\Frontend\Events\EventController;
use App\Http\Controllers\Frontend\Exams\ExamCenterController;
use App\Http\Controllers\Frontend\Payment\PaymentController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\UserNoteController;
use App\Http\Controllers\Frontend\User\UserProgramController;
use App\Http\Controllers\Frontend\User\UserProgramFeeController;
use App\Http\Controllers\Frontend\User\UserProgramResourceController;
use App\Http\Controllers\Frontend\User\UserProgramVideoController;
use App\Http\Controllers\Frontend\User\UserSupportController;
use App\Http\Controllers\Payment\VoucherController;
use Illuminate\Support\Facades\Route;

include __DIR__ . "/arthapanchawk.php";

Route::get('/guru-parampara', function () {
    return view("frontend.page.menus.guru-parampara");
})->name("guru-parampara");

Route::get('/jagadguru', function () {
    return view("frontend.page.menus.gurudev");
})->name("jagadguru");

Route::get('/events/atirudri', function () {
    return view("frontend.page.menus.atirudri");
})->name("events.atirudri");

Route::name('legal.')
    ->group(function () {
        Route::get("/terms-and-conditions", fn() => view("frontend.page.legal.terms"))->name('terms');
        Route::get("/privacy", fn() => view("frontend.page.legal.privacy"))->name('privacy');
    });


Route::prefix("account")
    ->name("user.account.")
    ->middleware(["auth"])
    ->group(function () {

        Route::get("/user/notifications", [ProfileController::class, "notifications"])->name("notifications");
        Route::match(['get', 'post'], "/user/connections", [ProfileController::class, "connections"])->name("connections");
        Route::post('user/connection/delete/{connection}', [ProfileController::class, 'deleteConnection'])->name('connection.delete');
        Route::get("/user/{member?}", [ProfileController::class, "account"])->name("list");
        Route::post("/profile", [ProfileController::class, "storeProfile"])->name("store.profile");
        Route::post("/profile/detail/{member?}", [ProfileController::class, "storeDetail"])->name("store.personal");
        Route::post('/user/notifications/{notification}', [ProfileController::class, "singleNotification"])->name('notification-body');
        Route::post('/user/notifications/{notification}/update', [ProfileController::class, "markNotification"])->name('notification-update');
        Route::post('/user/end/', [ProfileController::class, 'removeAdminAccess'])->name('end_debug_session');

        Route::get("/dashboard", [ProfileController::class, "index"])->name("dashboard");
        Route::prefix("notes")
            ->controller(UserNoteController::class)
            ->name("notes.")
            ->group(function () {
                Route::resource('notes', UserNoteController::class);
            });

        Route::prefix("support")
            ->controller(UserSupportController::class)
            ->name("support.")
            ->group(function () {
                Route::post('/reply/{ticket}', "replyTicket")->name('ticket.reply');
                Route::post('/ticket/close/{ticket}', "closeTicket")->name('ticket.close');
                Route::resource("ticket", UserSupportController::class);
            });

        Route::prefix("events")
            ->controller(EventController::class)
            ->name('event.')
            ->group(function () {
                Route::get('/calendar', "calendar")->name('calendar');
                Route::post('/join/admin/{live}', 'join_as_admin')->name('live_as_admin');
                Route::post('/join/{program}/{live}', "liveEvent")->name('live');
                Route::post('/join/open/{program}/{live}', "joinOpenEvent")->name('live_open');
            });

        Route::prefix("dharmashala")
            ->controller(DharmashalaController::class)
            ->name("dharmashala.")
            ->group(function () {
                Route::get("/", "index")->name("booking.index");
                Route::get("/create", "create")->name("booking.create");
            });

        Route::prefix('exams')
            ->controller(ExamCenterController::class)
            ->name('exams.')
            ->group(function () {
                Route::get("/", "index")->name("exam.index");
                Route::get("/result", "result")->name("exam.result");
            });

        Route::prefix("programs")
            ->controller(UserProgramController::class)
            ->name("programs.")
            ->group(function () {
                Route::get("/", "index")->name("program.index");
                Route::get("/request/leave/{program}/list", "requestLeaveList")->name("program.request.index");
                Route::get("/request/leave/{program}/create", "requestLeaveCreate")->name("program.request.create");
                Route::get("/resource/{program}/", "resources")->name("program.resources");
                Route::get("/resource/offline/video/{program}/", "offlineVideo")->name("program.offline.video");
                Route::get("/resource/notices/{program}/", "notices")->name("program.notices");
                Route::post("/request/leave/{program}/create", "requestLeaveStore")->name("program.request.store");

                /**
                 * Resources
                 */
                Route::prefix("resources")
                    ->name('resources.')
                    ->controller(UserProgramResourceController::class)
                    ->group(function () {
                        Route::get("/list/{program}", "index")->name('index');
                        Route::get("/show/{program}/{programResource}", "show")->name('show');
                    });

                /**
                 * Offline Video
                 */
                Route::prefix("videos")
                    ->name('videos.')
                    ->controller(UserProgramVideoController::class)
                    ->group(function () {
                        Route::get("/list/{program}", "index")->name("index");
                        Route::get("/list/{program}/{course}/{lession}", "videos")->name("show");
                        Route::post("/list/{program}/{course}/{lession}", "videos")->name("show");
                        Route::post("/watch/history/{program}/{course}/{lession}", 'storeHistory')->name('store.history');
                        Route::post("/video/check/permission/{program}/{lession?}", "allowedToWatch")->name('video-permission');
                        Route::get('/lession/{course}/{lessionID?}', [CourseControllerAPI::class, 'lession'])->name('video-lession');
                    });

                /**
                 * Course Fee
                 */
                Route::prefix("courses/fee")
                    ->name('courses.fee.')
                    ->controller(UserProgramFeeController::class)
                    ->group(function () {
                        Route::get("/transactions/{program}", "index")->name('list');
                    });


                /**
                 * Program Payment option.
                 */

                Route::prefix('payment/program/{program}')
                    ->name('payment.')
                    ->group(function () {
                        Route::get('process', [PaymentController::class, 'create'])->name('create.form');
                        Route::post('process', [PaymentController::class, 'stripeAdmissionFeeControllerr'])->name('stripe.process');
                        Route::post("/voucher", [VoucherController::class, 'store'])->name('store.voucher');
                    });
            });
    });

include __DIR__ . "/donation.php";

include __DIR__ . "/support.php";

include __DIR__ . "/memberSadhak.php";

include __DIR__ . '/centerAdmin.php';

include __DIR__ . "/sadhak.php";

include __DIR__ . "/dikshya.php";

include __DIR__ . "/jaap.php";

Route::middleware(['teacher', 'web', 'auth'])
    ->group(function () {
        include __DIR__ . '/../admin/modal.php';
    });
