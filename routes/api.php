<?php

use App\Http\Controllers\Admin\Batch\AdminBatchController;
use App\Http\Controllers\API\Batch\BatchAPIController;
use App\Http\Controllers\API\Fee\FeeAPIController;
use App\Http\Controllers\API\Program\ProgramAPIController;
use App\Http\Controllers\API\Student\StudentAPIController;
use App\Http\Controllers\API\Zoom\ZoomAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("v1")
    ->group(function () {
        Route::get("/cities", function () {
            if (request()->country) {
                $cities = \App\Models\City::select(["id", "name as text"])->where("country_id", request()->country)->get();
            } else {
                $cities = \App\Models\City::select(["id", "name as text"])->get();
            }
            return response(['results' => $cities]);
        })->name("cities-list");
    });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix("v1")
    ->middleware('auth')
    ->group(function () {
        Route::prefix("zoom")
            ->name('zoom.')
            ->group(function () {
                Route::get("/account-list", [ZoomAPIController::class, "zoom_account_list"]);
                Route::post("/store-meeting", [ZoomAPIController::class, "store_zoom_meeting"])->name('admin_api_store_zoom_meeting');
                Route::post("update-zoom-meeting/{meeting}", [ZoomAPIController::class, "update_zoom_meeting"])->name("admin_api_update_zoom_meeting");
            });
        Route::prefix("batch")
            ->name('batch.')
            ->group(function () {
                Route::get("/list", [BatchAPIController::class, "list"])->name("admin_api_batch_list");
            });

        Route::prefix("program")
            ->name('program.')
            ->group(function () {
                Route::get('/list', [ProgramAPIController::class, "list_program"])->name('admin_api_list_program');
                Route::post("/program/add", [ProgramAPIController::class, "store_program"])->name("admin_api_program_add");
                Route::post("/program/update/{program}", [ProgramAPIController::class, "update_program"])->name("admin_api_program_update");
                Route::post("/program/course/fee/{program}", [ProgramAPIController::class, "store_program_course_fee_structure"])->name("admin_api_program_course_fee_store");
            });

        /**
         * Member 
         */
        Route::prefix('member')
            ->name('member.')
            ->group(function () {
                Route::get("/list/program/{program}", [StudentAPIController::class, "list_student_by_program"])->name("admin_api_student_list_by_program");
            });

        /**
         * Fees
         */

        Route::prefix('fee')
            ->name('fee.')
            ->group(function () {
                Route::put("transaction/update/status/{fee_detail}", [FeeAPIController::class, "update_fee_status"])->name('api_update_fee_detail');
                Route::delete("transaction/delete/{fee}", [FeeAPIController::class, "delete_fee_transaction"])->name('api_delete_fee');
            });
    });



require base_path('routes/api/v1/api.php');
