<?php

use App\Http\Controllers\Admin\Members\MemberSadhanaController;
use Illuminate\Support\Facades\Route;

Route::prefix('member/member-sadhana')
        ->group(function(){

            Route::match(['get','post'],'add-sadhana/{member?}',[MemberSadhanaController::class,'add'])
                    ->name('member-sadhana.add');

            Route::match(['get','post'],'edit-dikshya/{sadhana}/{member?}',[MemberSadhanaController::class,'edit'])
                    ->name('member-sadhana.edit');

            Route::match(['post','delete'],'delete-member-dikshya/{sadhana}/{member?}',[MemberSadhanaController::class,'delete'])
                    ->name('member-sadhana.delete');
        });
