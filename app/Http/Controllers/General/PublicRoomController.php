<?php

namespace App\Http\Controllers\General;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class PublicRoomController extends Controller
{
    //
    public function index() {
        $bookings = Booking::where('user_detail_id',auth()->user()->user_detail_id)
                            ->where( function ($query) {
                                return $query->where('is_reserved',true)
                                            ->orWhere('is_occupied',true);
                            })
                            ->Where(function($query) {
                                return $query->where('status',"reserved")
                                            ->orWhere('status',"booked");
                            })
                            ->latest()->get();
        return view('public.user.rooms.index',compact('bookings'));
    }

    public function create(Request $request) {
        $bookings = Booking::where('user_detail_id',auth()->user()->user_detail_id)
                            ->where(function($query) {
                                return $query->where('is_reserved',true)
                                            ->orWhere('is_occupied',true);
                            })
                            ->Where(function($query) {
                                return $query->where('status',"reserved")
                                            ->orWhere('status',"Booked");
                            })
                            ->latest()->get();
        if ( $bookings->count() ) {
            $request->session()->flash('message',"You have active reservation. Please remove previous booking / reservation in order to proceed.");
            return back();
        }

        return view("public.user.rooms.add-new-booking");
    }

    public function check_avaibility(Request $request) {
        // dd($request->all()); 
        $request->validate([
            'visit_date' => "required|date_format:Y-m-d",
            'total_staying' => "required|numeric",
            "room" => "required|exists:rooms,id"
        ]);

        // check if this date is booked or reserved.
        $current_booking = Booking::where('user_detail_id',auth()->user()->user_detail_id)
                                    ->where('is_reserved',true)
                                    ->Where(function($query) {
                                        return $query->where('status',"reserved")
                                                    ->orWhere('status',"booked");
                                    })
                                    ->latest()->get();
        if ( $current_booking->count() ) {
            
            if ( $request->ajax() ) {
                return response([
                    'success' => false,
                    'message' => "Your previous booking is active. Please clear previous record to proceed."
                ]);
            }
            $request->session()->flash('message','Your previous booking is active. Please clear previous record to proceed.');
            return back();
        }

        // now lets check if booking date is available.
        $booking_date = \Carbon\Carbon::createFromFormat('Y-m-d',$request->visit_date);
        $booking_end_date  = $booking_date->addDays($request->total_staying);
        
        $booking = Booking::query()
                            ->where('rooms_id',$request->room)
                            ->where( function ($query) {
                                return $query->where('is_reserved', false)
                                            ->orWhere('is_reserved',null);
                            })
                            ->where ( function ($query ) {
                                return $query->where('is_occupied', false)
                                            ->orWhere('is_occupied', null);
                            })
                            ->where ( function ($query) {
                                return $query->where('status', ' != ', 'Booked')
                                            ->where('status', ' != ', 'reserved');
                            })
                            ->where(function (Builder $query) use ($request,$booking_end_date) {
                                $query->where(function (Builder $query) use ($request) {
                                    $query->where('check_in_date','<=',$request->visit_date)
                                            ->where('check_out_date','>=',$request->visit_date);
                                })
                                ->orWhere(function (Builder $query) use ($booking_end_date) {
                                    $query->where('check_in_date', '<=', $booking_end_date)
                                        ->where('check_out_date', '>=', $booking_end_date);
                                });
                            })->exists();
        // if (! $booking ) {
            session()->put("u_".auth()->id()."_".auth()->user()->user_detail_id,$request->except("_token"));
            // session::save();
        // }
        return view("public.user.rooms.room-avaibility-message",compact('booking'));

    }

    public function confirm_booking(Request $request) {
        // now lets confirm this booking.
        $request->validate([
            'visit_date' => "required|date_format:Y-m-d",
            'total_staying' => "required|numeric",
            "room" => "required|exists:rooms,id"
        ]);
        if ( $request->except("_token") === $request->session()->get("u_".auth()->id()."_".auth()->user()->user_detail_id) ) {
            
            $booking_date = \Carbon\Carbon::createFromFormat('Y-m-d',$request->visit_date);
            $booking_end_date  = $booking_date->addDays($request->total_staying);
    
            $booking = [
                "rooms_id" => $request->room,
                "user_detail_id" => auth()->user()->user_detail_id,
                "check_in_date" => $request->visit_date,
                "check_out_date" => $booking_end_date,
                "is_occupied" => false,
                "status" => "reserved",
                "is_reserved" => true,
                "total_duration" => $request->total_staying,
                "created_by_user" => auth()->user()->user_detail_id
            ];

            try {
                Booking::create($booking);
            } catch (\Throwable $th) {
                //throw $th;
                return "<p class='text-info'>We are currently unable to process your request.</p>";
            }
            session()->forget("u_".auth()->id()."_".auth()->user()->user_detail_id);
            return view("public.user.rooms.comfirm-booking");
        } 
        return "<p class='text-danger'>Permission Denied ! Repetion of this behaviour my result in account ban. <a href='".route('public.room.public_add_new_room_bookings')."'>Re-entry</a></p>";
    }

    public function clear_reservation(Request $request , $reservation_id){
        $reservation = Booking::findOrFail(decrypt($reservation_id));
        $reservation->check_out_date = date("Y-m-d H:i A");
        $reservation->status = "Reservation Cancelled";
        $reservation->is_reserved = null;   
        $reservation->remarks = ( ! $reservation->remarks && $request->remarks) ? $request->remarks : $reservation->remarks;

        // booking clearance record.
        try {
            \DB::transaction(function() use ($request,$reservation) {
                $reservation->save();
                $bookingClearanceController = new \App\Http\Controllers\BookingClearanceController;
                $bookingClearanceController->store($request,$reservation);
            });
            // $reservation->delete();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            $request->session()->flash('message',"Unable to complete your request.");
            return back();
        }

        $request->session()->flash('success',"Reservation cleared.");
        return back();
    }

    public function booking_history(Request $request){

        $bookings = Booking::where("user_detail_id",auth()->user()->user_detail_id)->paginate(20);
        return view("public.user.rooms.history", compact('bookings'));
    }
}
