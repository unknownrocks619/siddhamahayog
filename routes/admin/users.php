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
        Route::get('list/{center?}',[UserController::class,'index'])->name('admin.users.list');
        Route::match(['get','post'],'create/{center?}',[UserController::class,'create'])->name('admin.users.create');
        Route::match(['get','post'],'edit/{user}/{center?}',[UserController::class,'edit'])->name('admin.users.edit');
        Route::match(['delete','post'],'delete/{user}/{center?}',[UserController::class,'delete'])->name('admin.users.delete');
        Route::match(['get','post'],'list/modal/center-add-list/{center}',[UserController::class,'modalUserList'])->name('admin.users.modal-user-list');
        Route::post('logout',[UserController::class,'logout'])->name('admin.users.logout');
    });