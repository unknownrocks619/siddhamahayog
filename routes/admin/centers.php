<?php

use App\Http\Controllers\Centers\CenterMemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('centeres')
    ->group(function(){

        Route::get('list',[CenterMemberController::class,'index'])->name('centers.list');
        Route::match(['get','post'],'create',[CenterMemberController::class,'create'])->name('centers.create');
});
