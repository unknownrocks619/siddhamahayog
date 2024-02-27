<?php
use Illuminate\Support\Facades\Route;

Route::prefix('permission-request')
        ->group(function() {
            Route::match(['get','post'],'list/{permission?}/{type?}',[App\Http\Controllers\Admin\PermissionRequest\PermissionRequestController::class,'index'])
                ->name('permission-request.list');
        });
