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
                        Route::match(['get','post'],'edit/{building}',[BuildingController::class,'edit'])->name('admin.dharmasala.building.edit');
                        Route::match(['delete','get','post'],'delete/{building}',[BuildingController::class,'delete'])->name('admin.dharmasala.building.delete');
                    });

            /**
             * Floors
             */
            Route::prefix('floors')
                    ->group(function() {
                        Route::match(['get','post'],'create/{building?}',[DharmasalaFloorController::class,'create'])->name('admin.dharmasala.floor.create');
                        Route::match(['delete','get','post'],'delete/{floor}',[DharmasalaFloorController::class,'delete'])->name('admin.dharmasala.floor.delete');
                    });
            /** Rooms */
            Route::prefix('rooms')
                    ->group( function() {
                        Route::get('list',[RoomController::class,'index'])->name('admin.dharmasala.rooms.list');
                        Route::match(['get','post'],'create/{building?}/{floor?}',[RoomController::class,'create'])->name('admin.dharmasala.rooms.create');
                        Route::match(['get','post','delete'],'delete/{room}',[RoomController::class,'delete'])->name('admin.dharmasala.rooms.delete');
                    });

            /** Bookings */
            Route::prefix('bookings')
                    ->group(function () {
                        Route::get('list/{filter?}',[BookingController::class,'index'])
                                ->name('admin.dharmasala.booking.list');
                        Route::match(['post'],'update/{booking}',[BookingController::class,'update'])
                                ->name('admin.dharmasala.booking.update');

                        Route::get('confirmation/{booking}',[BookingController::class,'confirmation'])
                                ->name('admin.dharmasala.booking.confirmation');

                        Route::get('room-selection/{booking}',[BookingController::class,'updateRoom'])
                                ->name('admin.dharmasala.booking.update-room');

                        Route::match(['get','post'],'create/{room?}/{floor?}/{building?}',[BookingController::class,'create'])
                                ->name('admin.dharmasala.booking.create');

                        Route::get('user-search',[BookingController::class,'selectUsers'])
                                ->name('admin.dharmasala.booking-user-list');

                        Route::match(['post','put'],'check-in-reservation/{booking}',[BookingController::class,'checkIn'])
                                ->name('admin.dharmasala.booking-check-in-reservation');

                        Route::match(['post','put'],'check-out-reservation/{booking}',[BookingController::class,'checkOut'])
                            ->name('admin.dharmasala.booking-check-out-reservation');

                        Route::match(['post','put'],'cancel-reservation/{booking}',[BookingController::class,'cancelReservation'])
                                ->name('admin.dharmasala.booking-cancel-reservation');

                        Route::post('upload-capture-media',[BookingController::class,'uploadMemberMedia'])
                                ->name('admin.dharmasala.save-camera-image');

                        Route::post('update-booking-status/{booking}/{type}',[BookingController::class,'bookingConfirmation'])
                                ->name('admin.dharmasala.update-booking-status');

                        Route::get('quick-navigation/{booking}',[BookingController::class,'bookingQuickEditAjax'])
                                ->name('admin.dharmasala.quick-navigation');
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
