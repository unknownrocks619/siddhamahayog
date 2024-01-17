<?php

use App\Http\Controllers\Admin\Select2\Select2Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('select2')
        ->group(function() {
            Route::get('select2/list/batch',[Select2Controller::class,'batch'])
                    ->name('select2.batch-list');

            Route::get('select2/list/program-section/{program}',[Select2Controller::class,'sections'])
                ->name('select2.program-section-list');

            Route::get('select2/list/building',[Select2Controller::class,'buildings'])
                ->name('select2.dharmasala.building.list');

            Route::get('select2/list/floor/{building}',[Select2Controller::class,'floors'])
                ->name('select2.dharmasala.floor.list');

            Route::get('select2/list/room/list/{building?}/{floor?}',[Select2Controller::class,'rooms'])
                ->name('select2.dharmasala.room.list');
        });
