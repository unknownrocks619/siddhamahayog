<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBooking;
use Illuminate\Http\Request;

class OnlineBookingController extends  Controller
{

    public function index(Request $request) {
        return (new BookingController)->index($request,DharmasalaBooking::BOOKING);
    }
}
