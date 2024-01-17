<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBuilding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'no_of_floors'  => $request->post('total_floors') ?? 0,
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

    public function edit(Request $request, DharmasalaBuilding $building) {
        if (! $request->post() ) {
            abort(404);
        }

        $building->fill([
            'building_name' => $request->post('building_name'),
            'no_of_floors'  => $request->post('total_floors') ?? 0,
            'building_location' => $request->post('building_location'),
            'building_color'    => $request->post('building_color'),
            'status'    => $request->post('status'),
            'building_category' => $request->post('building_category'),
            'online'    => $request->post('online_accessible')
        ]);

        if (! $building->save() ) {
            return $this->json(false,'Unable to save. Please try agian.');
        }

        return $this->json(true,'Building information updated.','reload');
    }
    public function delete(Request $request, DharmasalaBuilding $building) {
        try {
            DB::transaction(function() use ($building) {
                foreach ($building->floors as $floor) {
                    $floor->rooms()->update(['floor_id' => null,'building_id' => null]);
                    $floor->delete();
                }
                $building->delete();
            });
        } catch (\Error $error) {
            return $this->json(false,'Unable to remove building.');
        }

        return $this->json(true,'Building Information Deleted.','reload');
    }
}
