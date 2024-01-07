<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBuilding;
use Illuminate\Http\Request;

class BuildingController extends  Controller
{
    public function index() {
        $buildings = DharmasalaBuilding::with(['floors'])->get();
        return view("admin.dharmasala.building.index",['buildings' => $buildings]);
    }
    public function create(Request $request) {
        $request->validate([
           'building_name'  => 'required',
        ]);

        $dharmasalaBuilding = new DharmasalaBuilding();
        $dharmasalaBuilding->fill([
            'building_name' => $request->post('building_name'),
            'no_of_floors'  => $request->post('total_floors'),
            'building_location' => $request->post('building_location'),
            'building_color'    => $request->post('building_color'),
            'status'    => $request->post('status'),
            'building_category' => $request->post('building_category'),
            'online'    => $request->post('online_accessible')
        ]);

        if ( ! $dharmasalaBuilding->save() ) {
            return $this->json(false,'Unable to create new building.');
        }
        return $this->json(true,'New building created.','reload');
    }
}
