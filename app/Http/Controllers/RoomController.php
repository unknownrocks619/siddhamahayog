<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;



class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()){
            $page = 'admin';
        }
        $rooms = Room::all();
        return view($page . ".rooms.index",compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::check()){
            $page = "admin";
        }

        return view($page.'.rooms.add');
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
        $user_post = $request->all();
        $user_post['created_by_user'] = "";
        if (Auth::check()) {
            $user_post["created_by_user"] = Auth::user()->id;
        }
        if (Room::create($user_post)){
            $request->session()->flash('success',"New Room has been created successfully.");
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $id)
    {
        //
        if (Auth::check()) {
            $page = "admin";
        }

        return view($page.'.rooms.edit',["room"=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $id)
    {
        //
        if($id->update($request->all())) {
            $request->session()->flash('success',"Room Detail has been successfully updated.");
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $id)
    {
        //
        $response = [];
        if ($id->delete()) {
            $response = [
                'success' => true,
                'message' => $id->room_number . " Room Number has been deleted"
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Oops, Unable to complete your action at the moment."
            ];
        }
        return response ($response);
    }

    public function check_avaibility(Request $request){
        $response = [];
        if ($request->room_number > 0 ){
            $room_detail = Room::findOrFail($request->room_number);
            $occupied_room = $room_detail->occupied_room->count();
            $reserved_room = $room_detail->is_reserved->count();
            $response["room_capacity"] = ($room_detail->room_capacity) ? $room_detail->room_capacity : "OPEN";
            $response['success'] = true;
            $response["room_name"] = $room_detail->room_name;
            $response["room_number"] = $room_detail->room_number;
            $response["occupied_room"] = $occupied_room;
            $response['available_room'] = ($room_detail->room_capacity) ? $room_detail->room_capacity - $occupied_room : "OPEN";
            $response["message"] = "Room Description";
            $response['available'] = "Available";
            $response["reservation_today"] = false;
            if ($reserved_room)
            {
                $reserved_date = $room_detail->is_reserved;
                $dates = [];
                foreach ($reserved_date as $run_reservation) {
                    $future_date = Carbon::createFromFormat("Y-m-d",$run_reservation->check_in_date);
                    $today = Carbon::createFromFormat("Y-m-d",date("Y-m-d"));    
                    if ($future_date->eq($today)) {
                        $response["reservation_today"] = "This room is reserved for Today. Please Select Another Room";
                        $response["available"] = "Not Available";
                    }
                    $dates[] = $run_reservation->check_in_date;
                }

                $response["reserved_dates"] = $dates;
            }

            if ($room_detail->room_capacity) {
                $response["available"] = ($response['available_room'] >= 1) ? "Available" : "Not Available";
            }

        } else{
            $response = [
                'success' => false,
                'message' => 'You must select valid Room to make a Visit log.',
                'available' => "Not Available"
            ];
        }
        return response($response);
    }

}
