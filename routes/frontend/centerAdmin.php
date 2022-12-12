<?php

use App\Http\Controllers\Centers\Admin\CenterAdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('center/admin')
    ->name('center.admin.')
    ->middleware(['auth', 'centerAdmin'])
    ->group(function () {
        Route::get('/dashboard', [CenterAdminDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('member')->name('member.')->group(function () {
            Route::get('/{member}/edit', [CenterAdminDashboardController::class, 'memberEdit'])->name('edit');
            Route::get('/{member}/show', [CenterAdminDashboardController::class, 'memberShow'])->name('show');
            Route::put('/{member}/edit', [CenterAdminDashboardController::class, 'memberUpdate'])->name('update');
            Route::post('/{member}/enroll', [CenterAdminDashboardController::class, 'memberEnrollStore'])->name('enroll_program');
            Route::post('/{member}/payment/store', [CenterAdminDashboardController::class, 'storeTransactionDetail'])->name('payment.store');
            Route::post('/{member}/reference/store', [CenterAdminDashboardController::class, 'storeMemberReference'])->name('reference.store');
        });
    });
