<?php

use App\Http\Controllers\Admin\Batch\AdminBatchController;
use App\Http\Controllers\Admin\CategoryController;
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
use App\Http\Controllers\Admin\Support\SupportTicketController;
use App\Http\Controllers\Admin\Website\Events\WebsiteEventController;
use App\Http\Controllers\Admin\Website\Menus\MenuController;
use App\Http\Controllers\Admin\Website\Settings\AdminSettingController;
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
    ->middleware(["auth", "admin"])
    ->group(function () {

        Route::get('/re-run/full-name', function () {

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
        Route::prefix("members")
            ->name('members.')
            ->controller(MemberController::class)
            ->group(function () {

                Route::get("/all", "index")->name('all');
                Route::get('/member/detail/{member}', "show")->name("show");
                Route::get("/add/{program}", "add_member_to_program")->name('admin_add_member_to_program');
                Route::get("/assign/{program}", "assign_member_to_program")->name('admin_add_assign_member_to_program');
                Route::get("/show/program/{member}/{program}", "programShow")->name('admin_show_for_program');
                Route::put('/update-password/{member}', 'updatePassword')->name('admin_change_user_password');
                Route::post('/add/{program}', "store_member_to_program")->name("admin_store_member_to_program");
                Route::post("/assign/{program}", "store_member_to_class")->name('admin_store_assign_member_to_program');
                Route::post("/show/program/{member}/{emergencyMeta}/{program?}", "programUpdate")->name('admin_update_for_program');
                Route::post("/update/{member}", "upate")->name("admin_update_member_basic_info");
                Route::post("/update/member/meta/{member}/{memberInfo?}", "updatePersonal")->name("admin_update_member_meta_info");
                Route::post("/reauth-as-user/{member}", "reauthUser")->name("admin_login_as_user");
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
            ->controller(AdminProgramController::class)
            ->group(function () {

                Route::get("/list/{type?}", "program_list")->name("admin_program_list");
                Route::get("/add/{type?}", "new_program")->name("admin_program_new");
                Route::get("/edit/{program}", "edit_program")->name("admin_program_edit");
                Route::get('/program/store/{program}', 'programBatchAndSectionModal')->name('admin_modal_program_meta_information');
                Route::get("/add/batch/modal/{program}", "add_batch_modal")->name("admin_program_add_batch_modal");
                Route::get("/detail/{program}", "program_detail")->name("admin_program_detail");
                Route::get("live-program/list", "liveProgram")->name('all-live-program');
                Route::get("live-program/list/join-as-admin/{live}", "rejoinSession")->name('live-program-as-admin');
                Route::get("live/{program}", "goLiveCreate")->name('live');
                Route::post("/add/batch/{program}", "store_batch_program")->name("admin_program_store_batch_modal");
                Route::post("/live/{program}", "storeLive")->name("store_live");
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

                Route::prefix("live")
                    ->name("live_program.")
                    ->group(function () {
                        Route::get('/merge/{program}/{live}', [AdminProgramController::class, "mergeSessionView"])->name("merge.view");
                        Route::post('/merge/{program}/{live}', [AdminProgramController::class, "mergeSessionStore"])->name("merge.store");
                        Route::post('/end-session/{live}', [AdminProgramController::class, "endLiveSession"])->name("end");
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
                        Route::get("/transaciton/voucher/file/{fee_detail}", [ProgramStudentFeeController::class, "display_uploaded_voucher"])->name('admin_display_fee_voucher');
                        Route::post('/store/{program}/{member}', [ProgramStudentFeeController::class, "store_fee_by_program"])->name('admin_store_student_fee');
                        Route::post('/store/fee-strucutre/new/{program}', [ProgramStudentFeeController::class, "store_program_course_fee_structure"])->name('admin_store_course_fee');
                        Route::get("/member-transaction/{program}/{member}", [ProgramStudentFeeController::class, "transaction_by_program_and_student"])->name('admin_fee_by_member');
                        Route::put("transaction/update/status/{fee_detail}", [FeeAPIController::class, "update_fee_status"])->name('api_update_fee_detail');
                        Route::delete("transaction/delete/{fee}", [FeeAPIController::class, "delete_fee_transaction"])->name('api_delete_fee');
                    });
                Route::prefix('enroll')
                    ->name('enroll.')
                    ->group(function () {
                        Route::get("/student/detail/{program}", [ProgramStudentEnrollController::class, "program_student_enrollement"])->name('admin_program_member_enroll');
                        Route::post("/student/enroll/{member}", [ProgramStudentEnrollController::class, "storeMemberInProgram"])->name('admin_student_enroll_in_program');
                        Route::post('/student/store/program/{program}/{member}', [ProgramStudentEnrollController::class, "enroll_student_in_program"])->name('admin_store_student_in_program');
                        Route::delete('/student/remove/{programStudent}', [ProgramStudentEnrollController::class, "RemoveEnrolledUser"])->name('admin_remove_student_from_program');
                    });


                Route::prefix('attendance')
                    ->name('attendances.')
                    ->controller(AdminProgramAttendanceController::class)
                    ->group(function () {
                        Route::get("/attendance/{program}", "index")->name('list');
                        Route::get("/attendance/{program}/{student}/{live}", "index")->name('detail');
                    });

                Route::prefix("scholarship")
                    ->name('scholarship.')
                    ->controller(StudentProgramScholarShipController::class)
                    ->group(function () {

                        Route::get('{program}/list', 'index')->name('list');
                        Route::post('{program}/list', 'storeScholarShip')->name('store');
                        Route::post('{program}/{student}/remove', 'removeStudent')->name('remove');
                    });

                Route::prefix('guest')
                    ->name('guest.')
                    ->controller(AdminProgramGuestListController::class)
                    ->group(function () {
                        Route::get('list/{program}', 'index')->name('list');
                        Route::post('store-guest/{program}', 'store')->name('store');
                        Route::post('delete/{program}/{guest}', 'delete')->name('delete');
                    });

                /**
                 * Unpaid Access
                 */
                Route::prefix("unpaid/access")
                    ->name('unpaid.access.')
                    ->controller(AdminProgramUnpaidAccessController::class)
                    ->group(function () {
                        Route::get('list/{program}', 'index')->name('list');
                        Route::get('list-view/{program}/{member}', 'joinedMeta')->name('list-view');
                        Route::post('reset/{access}', 'resetMeta')->name('reset');
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
        Route::prefix("notices")
            ->name("notices.")
            ->controller(Noticecontroller::class)
            ->group(function () {
                Route::resource("notice", Noticecontroller::class);
            });
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
                Route::get('filter', "filterIndex")->name('widget_by_type');
            });

        /**
         * 
         * Support Tickets
         *  
         * */
        Route::prefix('supports')
            ->name("suppports.")
            ->controller(SupportTicketController::class)
            ->group(function () {
                Route::get("list", "index")->name("tickets.list");
                Route::get("show/{ticket}", "show")->name("tickets.show");
                Route::post("show/{ticket}", "responseTicket")->name("tickets.store");
                Route::post("close/{ticket}", "closeTicket")->name("tickets.close");
            });

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
    });
