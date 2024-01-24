<?php

use App\Http\Controllers\Admin\Programs\AdminProgramAttendanceController;
use App\Http\Controllers\Admin\Programs\AdminProgramController;
use App\Http\Controllers\Admin\Programs\AdminProgramCourseController;
use App\Http\Controllers\Admin\Programs\AdminProgramGuestListController;
use App\Http\Controllers\Admin\Programs\AdminProgramSectionController;
use App\Http\Controllers\Admin\Programs\AdminProgramUnpaidAccessController;
use App\Http\Controllers\Admin\Programs\ProgramBatchController;
use App\Http\Controllers\Admin\Programs\ProgramCourseResourceController;
use App\Http\Controllers\Admin\Programs\ProgramStudentEnrollController;
use App\Http\Controllers\Admin\Programs\ProgramStudentFeeController;
use App\Http\Controllers\Admin\Scholarship\StudentProgramScholarShipController;
use App\Http\Controllers\API\Fee\FeeAPIController;
use Illuminate\Support\Facades\Route;

Route::prefix('programs')
    ->name("program.")
    ->controller(AdminProgramController::class)
    ->group(function () {

        Route::get("/list/{type?}", "program_list")->name("admin_program_list");
        Route::match(['post','get'],"/add/{type?}", "new_program")->name("admin_program_new");
        Route::match(['get','post'],"/edit/{program}", "edit_program")->name("admin_program_edit");
        Route::get('/program/store/{program}', 'programBatchAndSectionModal')->name('admin_modal_program_meta_information');
        Route::get("/add/batch/modal/{program}", "add_batch_modal")->name("admin_program_add_batch_modal");
        Route::get("/detail/{program}", "program_detail")->name("admin_program_detail");
        Route::get("live-program/list", "liveProgram")->name('all-live-program');
        Route::get('live-program/list/{live}/ramdas', 'ramdasList')->name('live-program-ramdas');
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
                Route::get("/list/lession/video/{program}/{course}", [AdminProgramCourseController::class, "list_video_modal"])->name("admin_program_video_list_lession_modal");
                Route::get("/list/lession/resources/{program}/{course}", [ProgramCourseResourceController::class, "list_resource_modal_admin"])->name("admin_program_course_list_lession_modal");
                Route::get("/add/resources/{course}", [ProgramCourseResourceController::class, "create_program_resource_modal"])->name('admin_program_course_add_resource_modal');


                Route::post("/add/{program}", [AdminProgramCourseController::class, "store_course"])->name('admin_program_course_add');
                Route::post("/edit/{course}", [AdminProgramCourseController::class, "update_course"])->name("admin_program_course_update");
                Route::post("/delete/{course}", [AdminProgramCourseController::class, "delete_course"])->name('admin_program_course_delete');
                Route::post("/add/lession/{course}", [AdminProgramCourseController::class, "store_course_lession_video"])->name("admin_program_course_store_lession_modal");
                Route::post("/add/resources/{course}", [ProgramCourseResourceController::class, "store_program_resource"])->name('admin_program_course_store_resource_modal');
                Route::post('/reorder/{program}', [AdminProgramCourseController::class, 're_order_course'])->name('admin_program_redorder_course');
                Route::post('/reorder/{program}/{course}', [AdminProgramCourseController::class, 're_order_lession'])->name('admin_program_redorder_lession');
            });

        Route::prefix("live")
            ->name("live_program.")
            ->group(function () {
//                Route::get('/merge/{program}/{live}', [AdminProgramController::class, "mergeSessionView"])->name("merge.view");
                Route::post('/merge/{program}/{live?}', [AdminProgramController::class, "mergeSessionStore"])->name("merge.store");
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
                Route::get('/list/{program}/{section}', 'sectionStudent')->name('admin_list_student_section');
                Route::get('/modal/list/{program}/{member}/{section}', 'changeSection')->name('admin_change_student_section');
                Route::get("/edit/{section}", [AdminProgramSectionController::class, "edit"])->name('admin_edit_section');
                Route::post('/store/{program}', [AdminProgramSectionController::class, "store"])->name("admin_store_section");
                Route::put("/edit/{section}", [AdminProgramSectionController::class, "update"])->name('admin_update_section');
                Route::put("/list/student/modal/{program}/{member}", "updateSection")->name("admin_update_students_update");
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
                Route::get("/transaction-program/{program}", [ProgramStudentFeeController::class, "transaction_by_program"])->name('admin_fee_transaction_by_program');
                Route::get("/transaction/voucher/file/{fee_detail}", [ProgramStudentFeeController::class, "display_uploaded_voucher"])->name('admin_display_fee_voucher');
                Route::get('/transaction/overview/unpaid/{program}',[ProgramStudentFeeController::class,'unpaidList'])->name('admin_display_unpaid_list');
                Route::post('/store/{member?}/{program?}', [ProgramStudentFeeController::class, "store_fee_by_program"])->name('admin_store_student_fee');
                Route::post('/store/fee-structure/new/{program}', [ProgramStudentFeeController::class, "store_program_course_fee_structure"])->name('admin_store_course_fee');
                Route::get("/member-transaction/{program}/{member}", [ProgramStudentFeeController::class, "transaction_by_program_and_student"])->name('admin_fee_by_member');
                Route::put("transaction/update/status/{fee_detail}", [FeeAPIController::class, "update_fee_status"])->name('api_update_fee_detail');
                Route::delete("transaction/delete/{fee}", [FeeAPIController::class, "delete_fee_transaction"])->name('api_delete_fee');
            });
        Route::prefix('enroll')
            ->name('enroll.')
            ->group(function () {
                Route::get("/student/detail/{program}", [ProgramStudentEnrollController::class, "program_student_enrollement"])->name('admin_program_member_enroll');
                Route::get('/student/roll/{programStudent}', [ProgramStudentEnrollController::class, "enrollmentDetail"])->name('admin_program_student_enroll_roll_number');
                Route::post("/student/roll/{programStudent}", [ProgramStudentEnrollController::class, "storeEnrollmentDetail"])->name('admin_store_student_enroll_roll_number');
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

        /**
         * Full section action
         */
        Route::prefix('section/list')
            ->name('section.')
            ->controller(AdminProgramSectionController::class)
            ->group(function () {
                Route::get('{program}/full-list/{section?}', 'student_list_per_section')->name('index');
                Route::post('{studentID}/update-access', 'fullSectionAccess')->name('section-access');
            });

        /**
         * Group
         */
        include __DIR__.'/grouping.php';
    });
