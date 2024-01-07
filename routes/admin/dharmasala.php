<?php

use App\Http\Controllers\Admin\Dharmasala\AmenitiesController;
use App\Http\Controllers\Admin\Dharmasala\BookingController;
use App\Http\Controllers\Admin\Dharmasala\BuildingController;
use App\Http\Controllers\Admin\Dharmasala\DharmasalaFloorController;
use App\Http\Controllers\Admin\Dharmasala\OnlineBookingController;
use App\Http\Controllers\Admin\Dharmasala\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/dharmasala')
        ->group(function() {

            /** Building */
            Route::prefix('building')
                    ->group(function() {
                        Route::get('list',[BuildingController::class,'index'])->name('admin.dharmasala.building.list');
                        Route::match(['get','post'],'create',[BuildingController::class,'create'])->name('admin.dharmasala.building.create');
                        Route::match(['get','post'],'edit',[BuildingController::class,'edit'])->name('admin.dharmasala.building.edit');
                        Route::match(['delete','get','post'],'delete',[BuildingController::class,'delete'])->name('admin.dharmasala.building.delete');
                    });

            /**
             * Floors
             */
            Route::prefix('floors')
                    ->group(function() {
                        Route::match(['get','post'],'create/{building?}',[DharmasalaFloorController::class,'create'])->name('admin.dharmasala.floor.create');
                    });
            /** Rooms */
            Route::prefix('rooms')
                    ->group( function() {
                        Route::get('list',[RoomController::class,'index'])->name('admin.dharmasala.rooms.list');
                        Route::match(['get','post'],'create',[RoomController::class,'create'])->name('admin.dharmasala.rooms.create');
                    });

            /** Bookings */
            Route::prefix('bookings')
                    ->group(function () {
                        Route::get('list',[BookingController::class,'index'])->name('admin.dharmasala.booking.list');
                    });

            /** Amenities */
            Route::prefix('amenities')
                    ->group(function() {
                        Route::get('list',[AmenitiesController::class,'index'])->name('admin.dharmasala.amenities.list');
                    });


            /** Online Bookings */
            Route::prefix('online-booking')
                    ->group( function() {
                        Route::get('list',[OnlineBookingController::class,'index'])->name('admin.dharmasala.online-booking.list');
                    });

        });
