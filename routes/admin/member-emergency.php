<?php

use App\Http\Controllers\Admin\Members\MemberEmergencyController;
use Illuminate\Support\Facades\Route;

Route::prefix('member/member-emergency')
    ->group(function(){
        Route::match(['get','post'],'add-emergency/{member}',[MemberEmergencyController::class,'add'])
                ->name('member.emergency.add');
        Route::match(['delete','post'],'delete-emergency/{emergencyMeta}',[MemberEmergencyController::class,'delete'])
            ->name('member.emergency.delete');
        Route::match(['post'],'upload-emergency-profile/{emergencyMeta}',[MemberEmergencyController::class,'uploadProfile'])
            ->name('member.emergency.profile-upload');
    });
