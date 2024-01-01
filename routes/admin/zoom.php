<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Zoom\AdminZoomAccountController;

Route::prefix("zoom")
    ->group(function () {
        Route::get("account", [AdminZoomAccountController::class, "zoom_accounts"])->name('admin_zoom_account_show');
        Route::get('account/create', [AdminZoomAccountController::class, "add_zoom_account"])->name("admin_zoom_account_create");
        Route::post("account/create", [AdminZoomAccountController::class, "store_zoom_account"])->name('admin_zoom_account_store');
        Route::match(['post','get'],"account/edit/{zoom}", [AdminZoomAccountController::class, "edit_account"])->name("zoom.admin_zoom_account_edit");
        Route::post("account/edit/{edit_id}", [AdminZoomAccountController::class, "update_zoom_account"])->name("admin_zoom_account_edit");
        Route::post('account/delete/{zoom}',[AdminZoomAccountController::class,'remove_account'])->name('zoom.delete');
    });
