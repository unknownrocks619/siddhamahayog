<?php
use Illuminate\Support\Facades\Route;
Route::prefix('jaap')
        ->middleware(['auth'])
        ->group(function() {
            Route::get('/jaap-setting',[\App\Http\Controllers\Frontend\Jaap\JappController::class,'modalSetting'])
                ->name('frontend.jaap.setting-pop-modal');

            Route::post('/jaap-setting/cancel-yagya',[\App\Http\Controllers\Frontend\Jaap\JappController::class,'cancelChoice'])
                ->name('frontend.jaap.cancel-jap-info');

            Route::post('/daily-jaap-count',[App\Http\Controllers\Frontend\Jaap\JappController::class,'insertDailyCounter'])
                ->name('frontend.jaap.counter-daily');

            Route::get('jaap-list/{program}',[\App\Http\Controllers\Frontend\Jaap\JappController::class,'indexYagya'])
                ->name('frontend.jaap.index');

            Route::get('/jaap-delete/{jap}',[\App\Http\Controllers\Frontend\Jaap\JappController::class,'deleteJaap'])
                    ->name('frontend.jaap.delete');
        });
