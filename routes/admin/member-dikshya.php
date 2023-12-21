<?php

use App\Http\Controllers\Admin\Members\MemberDikshyaController;
use Illuminate\Support\Facades\Route;

Route::prefix('member/member-dikshya')
        ->group(function(){

            Route::match(['get','post'],'add-dikshya/{member?}',[MemberDikshyaController::class,'add'])
                    ->name('member-dikshya.add');

            Route::match(['get','post'],'edit-dikshya/{dikshya}/{member?}',[MemberDikshyaController::class,'edit'])
                    ->name('member-dikshya.edit');

            Route::match(['post','delete'],'delete-member-dikshya/{dikshya}/{member?}',[MemberDikshyaController::class,'delete'])
                    ->name('member-dikshya.delete');
        });
