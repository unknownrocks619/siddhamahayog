<?php

use App\Http\Controllers\Admin\Batch\AdminBatchController;
use App\Http\Controllers\Admin\FileManager\AdminFileManagerController;
use App\Http\Controllers\Admin\Members\MemberController;
use App\Http\Controllers\Admin\Programs\AdminProgramController;
use App\Http\Controllers\Admin\Programs\AdminProgramCourseController;
use App\Http\Controllers\Admin\Programs\AdminProgramSectionController;
use App\Http\Controllers\Admin\Programs\ProgramBatchController;
use App\Http\Controllers\Admin\Programs\ProgramCourseResourceController;
use App\Http\Controllers\Admin\Programs\ProgramStudentEnrollController;
use App\Http\Controllers\Admin\Programs\ProgramStudentFeeController;
use App\Http\Controllers\Admin\Website\Events\WebsiteEventController;
use App\Http\Controllers\Admin\Website\Menus\MenuController;
use App\Http\Controllers\Admin\Website\Settings\AdminSettingController;
use App\Http\Controllers\Admin\Website\Slider\SliderController;
use App\Http\Controllers\Admin\Widget\WidgetController;
use App\Http\Controllers\Admin\Zoom\AdminZoomAccountController;
use App\Http\Controllers\Admin\Zoom\AdminZoomMeetingController;
use App\Models\ProgramCourseResources;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentEnroll;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get("/zoom", function () {
    // dd(zoom_meeting_details());
    // dd(register_participants());
    dd(create_zoom_meeting());
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(["auth", "admin"])
    ->group(function () {

        Route::get("/dashboard", function () {
            return view("admin.dashboard");
        })->name("admin_dashboard");
        /**
         * Staffs
         */

        /**
         * Users
         */
        Route::prefix("members")
            ->name('members.')
            ->group(function () {

                Route::get("/add/{program}", [MemberController::class, "add_member_to_program"])->name('admin_add_member_to_program');
                Route::get("/assign/{program}", [MemberController::class, "assign_member_to_program"])->name('admin_add_assign_member_to_program');
                Route::get("/show/program/{member}/{program}", [MemberController::class, "programShow"])->name('admin_show_for_program');
                Route::post('/add/{program}', [MemberController::class, "store_member_to_program"])->name("admin_store_member_to_program");
                Route::post("/assign/{program}", [MemberController::class, "store_member_to_class"])->name('admin_store_assign_member_to_program');
                Route::post("/show/program/{member}/{program}/{emergencyMeta}", [MemberController::class, "programUpdate"])->name('admin_update_for_program');
                Route::post("/update/{member}", [MemberController::class, "upate"])->name("admin_update_member_basic_info");
                Route::post("/update/member/meta/{memberInfo}", [MemberController::class, "updatePersonal"])->name("admin_update_member_meta_info");
            });
        /**
         * Zoom & Meetings
         */
        Route::prefix("zoom")
            ->group(function () {
                Route::get("account", [AdminZoomAccountController::class, "zoom_accounts"])->name('admin_zoom_account_show');
                Route::get('account/create', [AdminZoomAccountController::class, "add_zoom_account"])->name("admin_zoom_acount_create");
                Route::post("account/create", [AdminZoomAccountController::class, "store_zoom_account"])->name('admin_zoom_acount_store');
                Route::get("account/edit/{edit_id}", [AdminZoomAccountController::class, "edit_zoom_account"])->name("admin_zoom_account_edit");
                Route::post("account/edit/{edit_id}", [AdminZoomAccountController::class, "update_zoom_account"])->name("admin_zoom_account_edit");
            });
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
        Route::prefix('programs')
            ->name("program.")
            ->group(function () {
                Route::get("/list/{type?}", [AdminProgramController::class, "program_list"])->name("admin_program_list");
                Route::get("/add/{type?}", [AdminProgramController::class, "new_program"])->name("admin_program_new");
                Route::get("/edit/{program}", [AdminProgramController::class, "edit_program"])->name("admin_program_edit");
                Route::get("/add/batch/modal/{program}", [AdminProgramController::class, "add_batch_modal"])->name("admin_program_add_batch_modal");
                Route::get("/detail/{program}", [AdminProgramController::class, "program_detail"])->name("admin_program_detail");
                Route::get("live/{program}", [AdminProgramController::class, "goLiveCreate"])->name('live');
                Route::post("/add/batch/{program}", [AdminProgramController::class, "store_batch_program"])->name("admin_program_store_batch_modal");
                Route::post("/live/{program}", [AdminProgramController::class, "storeLive"])->name("store_live");
                /**
                 * Courses
                 */
                Route::prefix("courses")
                    ->name("courses.")
                    ->group(function () {
                        Route::get("/list/{program}", [AdminProgramCourseController::class, "index"])->name("admin_program_course_list");
                        Route::get('/add/{program}', [AdminProgramCourseController::class, "create"])->name("admin_program_course_add");
                        Route::get("/edit/{course}", [AdminProgramCourseController::class, "edit"])->name("admin_program_course_edit");
                        Route::get("/add/lession/{course}", [AdminProgramCourseController::class, "create_video_modal"])->name("admin_program_course_add_lession_modal");
                        Route::get("/list/lession/video/{course}", [AdminProgramCourseController::class, "list_video_modal"])->name("admin_program_video_list_lession_modal");
                        Route::get("/list/lession/resources/{course}", [ProgramCourseResourceController::class, "list_resource_modal_admin"])->name("admin_program_course_list_lession_modal");
                        Route::get("/add/resources/{course}", [ProgramCourseResourceController::class, "create_program_resource_modal"])->name('admin_program_course_add_resource_modal');

                        Route::post("/add/{program}", [AdminProgramCourseController::class, "store_course"])->name('admin_program_course_add');
                        Route::post("/edit/{course}", [AdminProgramCourseController::class, "update_course"])->name("admin_program_course_edit");
                        Route::post("/delete/{course}", [AdminProgramCourseController::class, "delete_course"])->name('admin_program_course_delete');
                        Route::post("/add/lession/{course}", [AdminProgramCourseController::class, "store_course_lession_video"])->name("admin_program_course_store_lession_modal");
                        Route::post("/add/resources/{course}", [ProgramCourseResourceController::class, "store_program_resource"])->name('admin_program_course_store_resource_modal');
                    });

                /**
                 * Sections
                 */
                Route::prefix("sections")
                    ->name("sections.")
                    ->controller(AdminProgramSectionController::class)
                    ->group(function () {
                        Route::get("/list/{program}", "index")->name('admin_list_all_section');
                        Route::get("/edit/{section}", [AdminProgramSectionController::class, "edit"])->name('admin_edit_section');
                        Route::post('/store/{program}', [AdminProgramSectionController::class, "store"])->name("admin_store_section");
                        Route::put("/edit/{section}", [AdminProgramSectionController::class, "update"])->name('admin_update_section');
                    });

                Route::prefix("batches")
                    ->name("batches.")
                    ->controller(ProgramBatchController::class)
                    ->group(function () {
                        Route::get("/list/{program}", "index")->name("admin_batch_list");
                        Route::get("/list/student/{program}/{member}", "changeBatch")->name("admin_batch_student_change");
                        Route::get("/list/student/modal/{program}/{batch}", "batchStudent")->name("admin_batch_students");
                        Route::post("/list/student/{program}", "storeBatch")->name("admin_batch_store");
                        Route::post("/list/student/{program}/{ProgramBatch}", "updateActive")->name("admin_batch_udpate_status");
                        Route::post("/list/student/modal/{program}/{member}", "updateBatch")->name("admin_batch_students_update");
                    });

                /**
                 * Fee
                 */
                Route::prefix("fee")
                    ->name('fee.')
                    ->group(function () {
                        Route::get("/add/{program}", [ProgramStudentFeeController::class, "add_fee_to_student_by_program"])->name('admin_program_create_fee');
                        Route::get('/overview/{program}', [ProgramStudentFeeController::class, "fee_overview_by_program"])->name('admin_fee_overview_by_program');
                        Route::get("/transaciton-program/{program}", [ProgramStudentFeeController::class, "transaction_by_program"])->name('admin_fee_transaction_by_program');
                        Route::post('/store/{program}/{member}', [ProgramStudentFeeController::class, "store_fee_by_program"])->name('admin_store_student_fee');
                        Route::get("/member-transaction/{program}/{member}", [ProgramStudentFeeController::class, "transaction_by_program_and_student"])->name('admin_fee_by_member');
                    });
                Route::prefix('enroll')
                    ->name('enroll.')
                    ->group(function () {
                        Route::get("/student/detail/{program}", [ProgramStudentEnrollController::class, "program_student_enrollement"])->name('admin_program_member_enroll');
                        Route::post('/student/store/program/{program}/{member}', [ProgramStudentEnrollController::class, "enroll_student_in_program"])->name('admin_store_student_in_program');
                    });
            });
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

        /**
         * Exams
         */
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
                        Route::get("/list", [AdminSettingController::class, "index"])->name("admin_website_settings");
                        Route::post('/update', [AdminSettingController::class, "update"])->name('admin_website_update_settings');
                    });

                /**
                 * Menus
                 */
                Route::prefix("menus")
                    ->name('menus.')
                    ->group(function () {
                        Route::get('/list', [MenuController::class, "index"])->name('admin_menu_list');
                        Route::get('/add', [MenuController::class, 'create'])->name('admin_create_menu');
                        Route::get("/edit/{menu}", [MenuController::class, "edit"])->name('admin_edit_menu');
                        Route::get('/settings', [MenuController::class, "settings"])->name('admin_settings');
                        Route::post('/store-menu', [MenuController::class, 'store'])->name('admin_store_menu');
                        Route::put('/update-menu/{menu}', [MenuController::class, "update"])->name('admin_update_menu');
                        Route::delete("/delete/{menu}", [MenuController::class, "delete"])->name('admin_delete_menu');
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

        /**
         * Settings
         */

        /**
         * Resources
         */
        Route::prefix("resources")
            ->name('resources.')
            ->group(function () {
                Route::get('/program/edit/{course}', [ProgramCourseResourceController::class, "edit_doc_by_program"])->name('admin_edit_course_resource');
                Route::get("/delete", [AdminFileManagerController::class, "delete_resource"])->name("admin_delete_resource");
                Route::prefix('videos')
                    ->name('videos.')
                    ->group(function () {
                    });
                Route::prefix('doc')
                    ->name('doc.')
                    ->group(function () {

                        Route::get('/list/program/{program}', [AdminFileManagerController::class, "doc_by_program"])->name('admin_doc_by_program');
                    });

                Route::post('/program/update/{resource}', [ProgramCourseResourceController::class, "update_program_resource"])->name("admin_update_course_resource");
            });
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
            });

        Route::resource("widget", WidgetController::class);
    });
