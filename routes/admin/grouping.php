<?php

use App\Http\Controllers\Admin\Programs\AdminProgramGroupController;
use Illuminate\Support\Facades\Route;
Route::prefix('grouping/{program}')
        ->group(function(){
            Route::match(['get','post'],'list-options',[AdminProgramGroupController::class,'index'])
                ->name('admin_program_grouping_index');
        });
