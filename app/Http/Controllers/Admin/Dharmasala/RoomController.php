<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use Illuminate\Http\Request;

class RoomController extends  Controller
{
    public function create(Request $request,DharmasalaBuilding $building=null,DharmasalaBuildingFloor $floor=null) {
        $request->validate([
            'room_number' => 'required'
        ]);

    }
}
