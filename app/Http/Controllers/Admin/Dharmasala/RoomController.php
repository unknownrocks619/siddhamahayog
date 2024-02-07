<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use Illuminate\Http\Request;

class RoomController extends  Controller
{
    public function index() {

        $rooms = DharmasalaBuildingRoom::with(['building','floor'])->withCount(['totalActiveReserved'])->get();
        return view('admin.dharmasala.rooms.list',['rooms' => $rooms]);
    }

    public function edit(Request $request, DharmasalaBuildingRoom $room) {
        
        if ( $request->post() && $request->ajax() ) {

            $request->validate([
                'room_number'   => 'required',
                'building'  => 'required',
                'floor' => 'required',
            ]);

            // check if room number exists

            if (DharmasalaBuildingRoom::where('room_number',$request->post('room_number'))
                                        ->where('building_id',$request->post('building'))->exists()) {

                return $this->json(false,'Room number already exists.');

            }

            $building = DharmasalaBuilding::where('id',$request->post('building'))->first();
            $floor = DharmasalaBuildingFloor::where('id', $request->post('floor'))->first();

            $room->fill([
                'room_number' => $request->post('room_number'),
                'building_id'       => $building->getKey(),
                'floor_id'          => $floor->getKey(),
                'room_capacity'     => $request->post('room_capacity'),
                'room_type'         => $request->post('room_type'),
                'room_category'     => $request->post('room_category'),
                'online'            => $request->post('online_booking'),
                'enable_booking'    => $request->post('enable_booking'),
                'available'         => $request->post('available')
    
            ]);
            
            if (! $room->save() ) {
                return $this->json(false,'Unable to update information.');
            }

            return $this->json(true,'Room Information Updated.');
        }

        return view('admin.dharmasala.rooms.edit',['room'=>$room]);
    }

    public function create(Request $request,DharmasalaBuilding $building=null,DharmasalaBuildingFloor $floor=null) {
        
        $request->validate([
            'room_number' => 'required'
        ]);

        if ( ! $building ) {
            
            $request->validate([
                'building'  => 'required'
            ]);

            $building = DharmasalaBuilding::where('id',$request->post('building'))->first();
        }

        if ( ! $floor ) {
            $request->validate([
                'floor' => 'required'
            ]);
            $floor = DharmasalaBuildingFloor::where('id', $request->post('floor'))->first();
        }

        $room = DharmasalaBuildingRoom::where('building_id', $building->getKey())
                                                ->where('room_number',$request->post('room_number'))
                                                ->exists();
        if ( $room ) {
            return $this->json(false,'Room number already exists.');
        }

        $room = new DharmasalaBuildingRoom();

        $room->fill([
            'room_number' => $request->post('room_number'),
            'building_id'       => $building->getKey(),
            'floor_id'          => $floor->getKey(),
            'room_capacity'     => $request->post('room_capacity'),
            'room_type'         => $request->post('room_type'),
            'room_category'     => $request->post('room_category'),
            'online'            => $request->post('online_booking'),
            'enable_booking'    => $request->post('enable_booking'),
            'available'         => $request->post('available')
        ]);
        
        if ($request->post('amenities') ) {
            
            $room->amenities = is_array($request->post('amenities')) ? $request->post('amenities') : [$request->post('amenities')];
        }

        if ( ! $room->save() ) {
            return $this->json(false,'Unable to save room information.');
        }

        return $this->json(true,'New Room Added.','reload');
    }

    public function delete(DharmasalaBuildingRoom $room) {
        if ( ! $room->delete() ) {
            return $this->json(false,'Unable to delete room. Please try again.');
        }
        return $this->json(true,'Room Information deleted.','reload');
    }
}
