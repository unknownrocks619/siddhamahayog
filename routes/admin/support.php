<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Support\SupportTicketController;

Route::prefix('supports')
        ->name("supports.")
            ->controller(SupportTicketController::class)
            ->group(function () {
                Route::get("list/{type?}/{filter?}", "index")->name("tickets.list");
                Route::get("show/{ticket}/{type?}/{filter?}", "show")->name("tickets.show");
                Route::post("show/{ticket}", "responseTicket")->name("tickets.store");
                Route::post("close/{ticket}", "closeTicket")->name("tickets.close");
        });
