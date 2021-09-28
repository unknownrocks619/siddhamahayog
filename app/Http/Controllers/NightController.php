<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Night;
use Illuminate\Support\Facades\Auth;

class NightController extends Controller
{
    public function store(Request $request, Booking $booking) {

            // if ( ! $request->user_detail_id &&  ! $userdetail) {
            //     return;
            // }

            $user_detail_id =  ($booking) ? $booking->user_detail_id : $request->user_detail_id;
            // let's search through previous record
            $previous_record = Night::where('user_detail_id',$user_detail_id)->first();

            if($previous_record) {
                $previous_record->nights +=  (int) $booking->total_duration;
                return $previous_record->save();
            }

            $night_store = [
                'user_detail_id' => $booking->user_detail_id,
                'nights' => (int) $booking->total_duration 
            ];
            return Night::create($night_store);
    }
}
