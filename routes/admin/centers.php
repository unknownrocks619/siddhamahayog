<?php

use App\Http\Controllers\Centers\CenterMemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('centers')
    ->group(function(){

        Route::get('list/{center?}',[CenterMemberController::class,'index'])->name('centers.list');
        Route::match(['get','post'],'create',[CenterMemberController::class,'create'])->name('centers.create');
        Route::match(['get','post'],'edit/{center}',[CenterMemberController::class,'edit'])->name('centers.edit');
        Route::match(['post','delete'],'delete/{center}',[CenterMemberController::class,'delete'])
            ->name('centers.delete');
});
