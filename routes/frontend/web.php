<?php

use App\Http\Controllers\Dharmashala\DharmashalaController;
use App\Http\Controllers\Frontend\Events\EventController;
use App\Http\Controllers\Frontend\Exams\ExamCenterController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\UserNoteController;
use App\Http\Controllers\Frontend\User\UserProgramController;
use App\Http\Controllers\Frontend\User\UserProgramFeeController;
use App\Http\Controllers\Frontend\User\UserProgramResourceController;
use App\Http\Controllers\Frontend\User\UserProgramVideoController;
use App\Http\Controllers\Frontend\User\UserSupportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

include __DIR__ . "/arthapanchawk.php";
// Route::get("/{slug}", [HomeController::class, "menu"])->name('slug');


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
        Route::get("/terms-and-conditions", fn () => view("frontend.page.legal.terms"))->name('terms');
        Route::get("/privacy", fn () => view("frontend.page.legal.privacy"))->name('privacy');
    });


Route::prefix("account")
    ->name("user.account.")
    ->middleware(["auth"])
    ->group(function () {

        Route::get("/user", [ProfileController::class, "account"])->name("list");
        Route::get("/user/connections", [ProfileController::class, "connections"])->name("connections");
        Route::get("/user/notifications", [ProfileController::class, "notifications"])->name("notifications");
        Route::post("/profile", [ProfileController::class, "storeProfile"])->name("store.profile");
        Route::post("/profile/detail", [ProfileController::class, "storeDetail"])->name("store.personal");
        Route::post('/user/notifications/{notification}', [ProfileController::class, "singleNotification"])->name('notification-body');
        Route::post('/user/notifications/{notification}/update', [ProfileController::class, "markNotification"])->name('notification-update');

        Route::get("/dashboard", [ProfileController::class, "index"])->name("dashboard");
        Route::prefix("notes")
            ->controller(UserNoteController::class)
            ->name("notes.")
            ->group(function () {
                Route::resource('notes', UserNoteController::class);
                // Route::get("/", "index")->name("notes");
                // Route::get("/create", "create")->name("notes_create");
                // Route::post("/store", "store")->name("store");
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
                Route::post('/join/{program}/{live}', "liveEvent")->name('live');
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
                        Route::post("/watch/history/{program}/{course}/{lession}", 'storeHistory')->name('store.history');
                        Route::post("/video/check/permission/{program}", "allowedToWatch")->name('video-permission');
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
            });
    });
include __DIR__ . "/donation.php";
include __DIR__ . "/support.php";
