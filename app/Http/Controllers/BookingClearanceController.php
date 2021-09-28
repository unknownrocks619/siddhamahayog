<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Booking;
use App\Models\BookingClearance;

class BookingClearanceController extends Controller
{
    //

    public function store(Request $request, Booking $booking){
        $store_data = [
            'bookings_id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'remarks' => ($request->remarks) ? $request->remarks : $booking->remarks,
            'created_by_user' => auth()->id()
        ];
        
        return BookingClearance::create($store_data);
    }
}
