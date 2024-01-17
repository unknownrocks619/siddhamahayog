<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DharmasalaFloorController extends Controller
{
    //
    public function create(Request $request, DharmasalaBuilding $building = null) {

        $request->validate([
            'floor_name'    => 'required'
        ]);

        if (! $building ) {
            $request->validate(['building' => 'required']);
            $building = DharmasalaBuilding::where('id',$request->post('building'))->first();
        }

        $buildingFloor = new DharmasalaBuildingFloor();

        $buildingFloor->fill([
            'floor_name'    => $request->post('floor_name'),
            'total_rooms'   => $request->post('total_rooms'),
            'building_id' => $building->getKey(),
            'status'    => $request->post('status'),
            'online'    => $request->post('online_access'),
            'room_prefix'   => $request->post('room_prefix') ?? substr($request->post('floor_name'),0,1)
        ]);

        if (! $buildingFloor->save() ) {
            return $this->json(false,'Unable to crate room.');
        }

        if ( $request->post('total_rooms') > 0 ) {

            $rooms = [];

//            for($i = 1 ; $i >= $request->post('total_rooms') ; $i++ ) {
//                $innerArray[] = [
//                    'room_name'
//                ]
//            }

        }

        return $this->json(true,'Floor Created.','reload');
    }

    public function delete(Request $request, DharmasalaBuildingFloor $floor){
        try {
            DB::transaction(function() use ($floor) {
               $floor->rooms()->update(['floor_id' => null]);
               $floor->delete();
            });
        } catch (\Error $error) {
            return $this->json(false,'Unable to delete floor information.');
        }
        return $this->json(true,'Floor information updated.');
    }
}
