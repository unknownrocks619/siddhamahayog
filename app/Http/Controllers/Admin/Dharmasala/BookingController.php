<?php

namespace App\Http\Controllers\Admin\Dharmasala;
use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use App\Models\Member;
use Illuminate\Http\Request;

class BookingController extends  Controller
{
    public function index() {
    }

    public function create(Request $request, DharmasalaBuildingRoom $room = null, DharmasalaBuildingFloor $floor=null, DharmasalaBuilding $building=null) {
//        $request->validate([
//           'member.*' => 'required'
//        ]);

        if ( ! $room ) {

            $request->validate([
               'room'   => 'required'
            ]);
            $room = DharmasalaBuildingRoom::where('id', $request->post('room'))->first();
        }

        if ( ! $floor ) {
            $floor = DharmasalaBuildingFloor::where('id',$room->floor_id)->first();
        }

        if (! $building ) {
            $building = DharmasalaBuilding::where('id',$room->building)->first();
        }

        $memberRecord = Member::whereIn('id',$request->post('members'))
                                ->with('profileImage','memberIDMedia')
                                ->get();

        $insertArray = [];
        foreach ($request->post('members') as $key => $value) {
            $member = $memberRecord->where('id',$value)->first();

            if ( ! $member) {
                continue;
            }

            $innerArray[] = [
                'room_number'   => $room->room_number,
                'building_id'   => $building->getKey(),
                'floor_id'      => $floor->getKey(),
                'room_id'       => $room->getKey(),
                'room_capacity' => $room->room_capacity,
                'building_name' => $building->building_name,
                'floor_name'    => $floor->floor_name,
                'member_id'     => $member->getKey(),
                'full_name'     => $member->full_name,
                'email'         => $member->email,
                'phone_number'  => $member->phone_number,
                'check_in'      => isset($request->post('check_in')[$key]) ? $request->post('check_in')[$key] : null,
                'check_out'     => isset($request->post('check_out')[$key]) ? $request->post('check_in')[$key]  : null,
                'profile'       => $member->profileImage?->filepath ? Image::getImageAsSize($member->profileImage?->filepath) :  null,
                'id_card'       => $member->memberIDMedia?->filepath ? Image::getImageAsSize($member->memberIDMedia?->filepath) :  null,
                'status'         => 'reserved'
            ];
        }

        try {
            DharmasalaBooking::insert($insertArray);
        } catch (\Error $error) {
            return $this->json(false,'Unable to create new record.');
        }

        return $this->json(true,' New booking confirmed.');

    }
    public function selectUsers(Request $request) {
        // search member and display result.
        $members = Member::where('email', $request->member)
                            ->orWhere('phone_number', 'like', '%' . $request->member . '%')
                            ->orWhere('first_name','LIKE','%'.$request->member.'%')
                            ->orWhere('last_name','LIKE','%'.$request->member.'%')
                            ->orWhere('full_name','LIKE','%'.$request->member.'%')
                            ->limit(30)
                            ->get();

        return view('admin.dharmasala.booking.partials.search-result', compact('members'));
    }
}
