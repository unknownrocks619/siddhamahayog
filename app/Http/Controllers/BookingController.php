<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\userDetail;
use App\Models\BookingClearance;
use App\Models\Donation;
use App\Models\Night;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display list of all bookings 
     * intended only for admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $bookings = Booking::select(
                    'check_in_date',
                    'user_detail_id',
                    'rooms_id',
                    'is_occupied',
                    'is_reserved',
                    'status',
                    'id'
                    )->where('status','Booked')
                    ->orWhere('status','Reserved')->get();
            return view('admin.bookings.list',compact('bookings'));
        abort(404);
    }

    /**
     * Show the form for creating a new booking resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request , $user_id = null)
    {
        //
        $data = [];
        $page = 'admin';
        if ($request->user_id || $user_id ) {
            // get user detail.
            $dec_user_id = ($user_id) ? decrypt($user_id) : ( ($request->user_id) ? decrypt($request->user_id)  : "");

            if ($dec_user_id)
            {
                $user_detail = userDetail::findOrFail($dec_user_id);
                $data['user_detail'] = $user_detail;
            } 
        }

        if (Auth::check() ){
            $page = "admin";
        }
        return view($page.".bookings.add",$data);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        // dd($request->all());
        $user_input = $request->all();
        $user_input['user_detail_id'] = $request->visitor;
        $user_input['check_in_date'] = $request->check_in_date . ' ' . $request->check_in_time;
        $user_input['created_by_user'] = auth()->check() ? auth()->id() : 0;
        $user_input['rooms_id'] = $request->room_number;

        // dd(date$user_input['check_in_date']);
        // lets check if date is from future..
        $user_date = Carbon::createFromFormat("Y-m-d",$request->check_in_date);
        $today = Carbon::createFromFormat("Y-m-d",date("Y-m-d"));
        if ($user_date->gt($today)) {
            $user_input['is_reserved'] = true;
            $user_input['status'] = "Reserved";
        } else {
            $user_input["is_occupied"] = true;
            $user_input["status"] = "Booked";
        }

        if (Booking::create($user_input) ) {
            $request->session()->flash("success",'New Visitor has been registered.');
            return  back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //

      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
        if ($request->check_out_visitor &&  ! $booking->check_out_date) {
            
            $booking->check_out_date = $request->check_out_date . " " . $request->check_out_time;
            $booking->is_occupied = null;
            $booking->status = "Out";
            $booking->remarks = ( ! $booking->remarks && $request->remarks) ? $request->remarks : $booking->remarks; 
            
            $check_in_date  = Carbon::createFromFormat("Y-m-d H:i A",$booking->check_in_date);
            
            $diff =  Carbon::parse($check_in_date)->diffForHumans(Carbon::now());
            $booking->total_duration = ($diff) ?  $diff : 1;
            $user_detail = $booking->userdetail;

            $request->user_detail_id = $booking->user_detail_id;

            $response = [];
            try {
                \DB::transaction( function () use ($request,$booking,$user_detail) {
                    $booking->save();
                    $bookingClearanceController = new BookingClearanceController;
                    $bookingClearanceController->store($request,$booking);
    
                    $donationTransactionController = new DonationTransactionController;
                    $donationTransactionController->store($request,$booking);
    
                    $donationController = new DonationController;
                    $donationController->store($request,$user_detail);
    
                    $nightController = new NightController;
                    $nightController->store($request,$booking);
                });
            } catch (\Throwable $th) {
                if ($request->ajax()){
                    $response =[
                        'success' => false,
                        'message' => "Oops, Something went wrong, Please try again."
                    ];    
                }
                $request->session()->flash('message',"Oops, Something went wrong, Please try again.");
                return back();
            }

            if ($request->ajax()) {
                $response = [
                    'success' => true,
                    'message' => "Visitor Room has been cleared."
                ];
                return response ($response);
            }
            $request->session()->flash('message',"Visitor Room has been cleared.");
            return back();
        } elseif ($request->check_out_visitor) {
            
            if ($request->ajax()){
                $response = [
                    'success' => false,
                    'message' => "This Room is no longer occupied by given user."
                ];
                return response ($response);
            }
            $request->session()->flash('message',"This Room was already cleared");
            return back();
        }



        if ($request->cancel_reservation){
            // dd($request->all());
            if ($request->arrival ) {
                $booking->status = "Booked";
                $booking->is_reserved = null;
                $booking->remarks = "Reservation was confirmed to booking.";
                $booking->is_occupied = true;
            } else {
                $booking->check_out_date = date("Y-m-d H:i A");
                $booking->status = "Reservation Cancelled";
                $booking->is_reserved = null;   
                $booking->remarks = ( ! $booking->remarks && $request->remarks) ? $request->remarks : $booking->remarks;
            }
            try {
                // $request->remarks = "Reservation Cancelled";
                \DB::transaction(function() use ($request,$booking) {
                    $booking->save();
                    if ( ! $request->arrival){
                        $bookingClearanceController = new BookingClearanceController;
                        $bookingClearanceController->store($request,$booking);
                    }
                });
            } catch (\Throwable $th) {
                //throw $th;
                if ($request->ajax()){
                    $response =[
                        'success' => false,
                        'message' => "Oops, Something went wrong, Please try again."
                    ];    
                }
                $request->session()->flash('message',"Oops, Something went wrong, Please try again.");
                return back();
            }

            if ($request->ajax()) {
                $response = [
                    'success' => true,
                    'message' => ($booking->status == "Booked" ) ? "Visitors Status Changed." : "Reservation has been cancelled."
                ];
                return response ($response);
            }
            $request->session()->flash('message',"Visitor Room has been cleared.");
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
