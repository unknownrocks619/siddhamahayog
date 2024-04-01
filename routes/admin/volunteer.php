<?php

use App\Http\Controllers\Admin\Programs\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::prefix('volunteer/{program}')
        ->name('volunteer.')
        ->group(function(){

                Route::get('/list',[VolunteerController::class,'index'])
                    ->name('admin_volunteer_list');
                Route::get('/volunteer/{volunteer}',[VolunteerController::class,'show'])
                        ->name('admin_volunteer_show');
                Route::match(['post'],'update-status/{volunteer}/{availableDates?}',[VolunteerController::class,'updateStatus'])
                        ->name('admin_volunteer_update_status');

        });
