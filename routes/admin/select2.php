<?php
use Illuminate\Support\Facades\Route;

Route::prefix('select2')
        ->group(function() {
            Route::get('select2/list/batch',[\App\Http\Controllers\Admin\Select2\Select2Controller::class,'batch'])
                    ->name('select2.batch-list');
            Route::get('select2/list/program-section/{program}',[\App\Http\Controllers\Admin\Select2\Select2Controller::class,'sections'])
                ->name('select2.program-section-list');
        });
