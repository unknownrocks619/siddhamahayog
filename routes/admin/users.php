<?php

use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/users')
    ->middleware('web')
    ->group(function() {
        Route::get('login',[UserController::class,'login'])->name('admin.users.login');
        Route::post('login',[UserController::class,'autheticate'])->name('admin.users.auth');

        Route::match(['get','post'],'forgot',[])->name('admin.users.forgot');
});

Route::prefix('admin/users')
    ->middleware(['admin'])
    ->group(function() {
        Route::get('list',[UserController::class,'index'])->name('admin.users.list');
        Route::match(['get','post'],'create',[UserController::class,'create'])->name('admin.users.create');

    });