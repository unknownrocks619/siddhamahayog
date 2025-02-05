<?php

use App\Http\Controllers\Admin\Batch\AdminBatchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CodeTestZoneController;
use App\Http\Controllers\Admin\FileManager\AdminFileManagerController;
use App\Http\Controllers\Admin\Members\MemberController;
use App\Http\Controllers\Admin\Notice\Noticecontroller;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\Programs\AdminProgramAttendanceController;
use App\Http\Controllers\Admin\Programs\AdminProgramController;
use App\Http\Controllers\Admin\Programs\AdminProgramCourseController;
use App\Http\Controllers\Admin\Programs\AdminProgramGuestListController;
use App\Http\Controllers\Admin\Programs\AdminProgramHolidayController;
use App\Http\Controllers\Admin\Programs\AdminProgramSectionController;
use App\Http\Controllers\Admin\Programs\AdminProgramUnpaidAccessController;
use App\Http\Controllers\Admin\Programs\ProgramBatchController;
use App\Http\Controllers\Admin\Programs\ProgramCourseResourceController;
use App\Http\Controllers\Admin\Programs\ProgramStudentEnrollController;
use App\Http\Controllers\Admin\Programs\ProgramStudentFeeController;
use App\Http\Controllers\Admin\Scholarship\StudentProgramScholarShipController;
use App\Http\Controllers\Admin\Website\Events\WebsiteEventController;
use App\Http\Controllers\Admin\Website\Menus\MenuController;
use App\Http\Controllers\Admin\Website\Settings\SettingController;
use App\Http\Controllers\Admin\Website\Slider\SliderController;
use App\Http\Controllers\Admin\Widget\WidgetController;
use App\Http\Controllers\Admin\Zoom\AdminZoomAccountController;
use App\Http\Controllers\Admin\Zoom\AdminZoomMeetingController;
use App\Http\Controllers\API\Fee\FeeAPIController;
use App\Http\Traits\SMS;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get("/zoom", function () {
    // dd(zoom_meeting_details());
    // dd(register_participants());
    // dd(create_zoom_meeting());
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', "admin"])
    ->group(function () {
        Route::get('/codetestzone', [CodeTestZoneController::class, 'getAllRegisteredSadhak']);
        Route::get('/re-run/full-name', function () {
            abort(404);
            $members = Member::select(['first_name', 'last_name', 'middle_name', 'id'])->cursor();

            foreach ($members as $member) {
                $full_name = $member->first_name;

                if ($member->middle_name) {
                    $full_name .= " ";
                    $full_name .= $member->middle_name;
                }
                $full_name .= " ";
                $full_name .= $member->last_name;

                $member->full_name = $full_name;

                $member->save();
            }

            echo "DONE !";
        });


        Route::get("/dashboard", function () {
            return view("admin.dashboard");
        })->name("admin_dashboard");

        /**
         * Staffs
         */

        /**
         * Users
         */

        include __DIR__ . '/admin/member.php';
        include __DIR__ . '/admin/member-dikshya.php';
        include __DIR__ . '/admin/member-sadhana.php';
        include __DIR__ . '/admin/member-emergency.php';

        /**
         * Zoom & Meetings
         */
        include __DIR__ . '/admin/zoom.php';

        Route::prefix("meeting")
            ->name("meeting.")
            ->group(function () {
                Route::get("/list-meeting", [AdminZoomMeetingController::class, "meetings"])->name('admin_zoom_meetings');
                Route::get("/create-meeting", [AdminZoomMeetingController::class, "create_meeting"])->name("admin_create_new_meeting");
                Route::get("edit-meeting/{meeting}", [AdminZoomMeetingController::class, "edit_zoom_meeting"])->name("admin_edit_meeting");
                ROute::post('/create-meeting', [AdminZoomMeetingController::class, "store_meeting"])->name("admin_zoom_meeting_store");
                Route::post('/update');
                Route::post("/delete");
            });

        /**
         * Batch
         */
        Route::prefix("batch")
            ->name("batch.")
            ->group(function () {
                Route::get("/list", [AdminBatchController::class, "batch"])->name("admin_batch_list");
                Route::get("/create-new-batch", [AdminBatchController::class, "create_batch"])->name('admin_batch_create');
                Route::get("/edit-batch-detail/{batch}", [AdminBatchController::class, "edit_batch"])->name('admin_edit_batch');
                // Route::get('/program/{batch}',[AdminBatchController::class,"batch_program"])->name("admin_batch_program_list");
                // Route::get("/program/{batch}/{program}",[AdminBatchController::class,"member_list_with_batch_program"])->name("admin_batch_program_members");

                Route::post("/store-new-batch", [AdminBatchController::class, "store_batch"])->name("admin_batch_store");
                Route::post("/edit-batch-detail/{batch}", [AdminBatchController::class, "update_batch"])->name('admin_update_batch');
                Route::post("/delete/{batch}", [AdminBatchController::class, "delete_batch"])->name("admin_delete_batch");
                // Route::get("")
            });

        /**
         * Programs
         */

        include __DIR__ . '/admin/program.php';

        /**
         * Finance
         */

        /**
         * Vimeo Video
         */
        Route::prefix("videos")
            ->name("videos.")
            ->group(function () {
                Route::get("/list/{program}", [AdminFileManagerController::class, "media_by_program"])->name("admin_list_videos_filemanager");
                Route::get("/edit/{program}/{video}", [AdminFileManagerController::class, "edit_media_by_program"])->name("admin_edit_video_by_program");
                Route::prefix('update')->name('update.')->group(function () {
                    Route::post("/video/{video}", [AdminFileManagerController::class, "update_video"])->name('admin_video');
                });
            });
        /**
         * Dharmashala Bookings
         */

        /**
         * Centers
         */
        include __DIR__ . '/admin/centers.php';

        /**
         * Exams
         */
        include __DIR__ . "/admin/exam-center.php";

        /**
         *  Modal
         */
        include __DIR__ . '/admin/modal.php';

        /**
         * Settings
         */
        Route::prefix('settings')
            ->name('settings.')
            ->group(function () {
                Route::get("/list", [SettingController::class, "index"])->name("index");
                Route::post('/update', [SettingController::class, "update"])->name('admin_website_update_settings');
            });


        /**
         * Website
         */
        Route::prefix('website')
            ->name('website.')
            ->group(function () {

                /**
                 * Settings
                 */
                Route::prefix('settings')
                    ->name('settings.')
                    ->group(function () {
                        Route::get("/list", [SettingController::class, "index"])->name("index");
                        Route::post('/update', [SettingController::class, "update"])->name('admin_website_update_settings');
                    });

                /**
                 * Menus
                 */
                Route::prefix("menus")
                    ->name('menus.')
                    ->controller(MenuController::class)
                    ->group(function () {

                        Route::post('/reoder', "reOrder")->name('reorder');
                        Route::PUT('/reoder-single/{menu}', "reOrderSingle")->name('reorder_position');
                        Route::get('module-link/{menu}', "modulesOptions")->name('link_module_options');
                        Route::get('module-link/manage/{menu}', "manageModule")->name('manage_module');
                        Route::post('module-link/{menu}', 'moduleAttach')->name('attach_module');
                        Route::delete('module-unlink/{menu}/{deatch_id}', 'moduleDeatch')->name('deatch_module');



                        Route::get('/list', "index")->name('admin_menu_list');
                        Route::get('/add', 'create')->name('admin_create_menu');
                        Route::get("/edit/{menu}", "edit")->name('admin_edit_menu');
                        Route::get('/settings', "settings")->name('admin_settings');
                        Route::post('/store-menu', 'store')->name('admin_store_menu');
                        Route::put('/update-menu/{menu}', "update")->name('admin_update_menu');
                        Route::delete("/delete/{menu}", "delete")->name('admin_delete_menu');
                    });

                /**
                 * Slider
                 */
                Route::prefix("slider")
                    ->name('slider.')
                    ->group(function () {

                        Route::get('/list', [SliderController::class, 'index'])->name('admin_slider_index');
                        Route::get("/add", [SliderController::class, "create"])->name('admin_slider_create');
                        Route::get("/edit/{slider}", [SliderController::class, "edit"])->name('admin_slider_edit');

                        Route::post('/add', [SliderController::class, "store"])->name('admin_slider_store');
                        Route::put("/edit/{slider}", [SliderController::class, "update"])->name('admin_slider_update');
                        Route::delete("delete/{slider}", [SliderController::class, "delete"])->name('admin_slider_delete');
                    });

                /**
                 * Events
                 */

                Route::prefix('events')
                    ->name('events.')
                    ->group(function () {

                        Route::resource('events', WebsiteEventController::class)->name("get", "event");
                    });
            });


        /**
         * Notices
         */
        include __DIR__ . '/admin/notices.php';

        /**
         * Settings
         */
        include('admin/settings.php');

        /**
         * Resources
         */

        include __DIR__ . '/admin/resources.php';
        /**
         * Calender
         */

        /**
         * Forum
         */

        /**
         * Widgets
         */

        /**
         * Admin Widgets
         */
        Route::prefix('widget')->name("widget.")
            ->controller(WidgetController::class)
            ->group(function () {
                Route::get('filter', "filterIndex")->name('widget_by_type');
            });

        /**
         *
         * Support Tickets
         *
         * */
        include __DIR__ . '/admin/support.php';

        /**
         * Holidays
         */
        Route::prefix('prefix')
            ->name('holidays.')
            ->controller(AdminProgramHolidayController::class)
            ->group(function () {
                Route::get("list", "index")->name('holiday.index');
                Route::get("show/{holiday}", "show")->name('holiday.show');
                Route::post('update/{holiday}', 'update')->name('holiday.update');
            });
        /**
         *
         * Category
         *
         */
        Route::prefix("categories")
            ->resource("category", CategoryController::class);
        /**
         *
         * Post
         *
         */
        Route::prefix("posts")
            ->controller(PostController::class)
            ->group(function () {
                Route::get("/widgets/{post}", "widgetView")->name('posts.widgets');
                Route::get("/widgets/modal/{post}", "widgetAdd")->name('posts.widgets.create');
                Route::post("/widgets/{post}", "widgetStore")->name('posts.widgets.store');
                Route::delete("/widgets/remove/{post}/{widget}", "widgetDestroy")->name('posts.widgets.destroy');
                Route::post("/remove/media/{post}", "removeMedia")->name("posts.destroy_media");
                Route::resource("post", PostController::class);
            });
        /**
         *
         * Page
         *
         */
        Route::prefix("pages")
            ->name('page.')
            ->controller(PageController::class)
            ->group(function () {
                Route::get("/widget/modal/{page}", "widgetAdd")->name('add_widget');
                Route::get('/widget/{page}', "widgetView")->name('manage_widget');
                Route::delete('/widget/remove/{page}/{widget}', "widgetDestroy")->name('destroy_widget');
                Route::post("/widget/modal/{page}", "widgetStore")->name('store_widget');
                Route::resource("page", PageController::class);
            });
        /**
         * Resources
         */
        Route::resource("widget", WidgetController::class);

        include __DIR__ . '/admin/select2.php';

        /**
         * Permission Request
         */
        include __DIR__ . '/admin/permissions-request.php';
    });
