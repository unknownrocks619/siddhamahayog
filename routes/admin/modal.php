<?php
use Illuminate\Support\Facades\Route;

Route::prefix('admin/modal')
        ->group(function() {
           Route::match(['get','post'],'display',
                        [\App\Http\Controllers\Admin\Modals\ModalController::class,'displayModal'])
                    ->name('modal.display');

        });
