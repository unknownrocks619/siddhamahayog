<?php

namespace App\Http\Controllers\Admin\Select2;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\City;
use App\Models\Country;
use App\Models\Dharmasala\DharmasalaBuilding;
use App\Models\Dharmasala\DharmasalaBuildingFloor;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use App\Models\Program;
use App\Models\ProgramSection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Select2Controller extends Controller
{


    public function select2AjaxResponse(array $result = [], int $totalRecord = 0): Response
    {
        return response(['results' => $result, 'count_filtered' => (!$totalRecord) ?  count($result) : $totalRecord]);
    }

    public function countries(Request $request, $countryCode  = null)
    {
        $countries = Country::select('id', 'name as text');

        if ($request->get('search')) {
            $countries->where('name', 'LIKE', '%' . $request->get('search') . '%');
        }

        $countries = $countries->get()->toArray();

        return $this->select2AjaxResponse($countries);
    }

    public function states(Request $request, Country $country)
    {
        $cities = City::select('id', 'name as text')->where('country_id', $country->getKey());

        if ($request->get('search')) {
            $cities->where('name', 'like', '%' . $request->get('search') . '%');
        }

        return $this->select2AjaxResponse($cities->get()->toArray());
    }

    public function batch(Request $request, ?Program $program) {
        $batches = Batch::select('id','batch_name as text');

        if ($request->get('search') )  {
            $batches->where('batch_name','LIKE','%'.$request->get('search').'%');
        }

        return $this->select2AjaxResponse($batches->get()->toArray());
    }

    public function sections(Request $request, Program $program) {
        $sections = ProgramSection::select('id','section_name as text')->where('program_id', $program->getKey());

        if ($request->get('search') ) {
            $sections->where('section_name',$request->get('search'));
        }

        return $this->select2AjaxResponse($sections->get()->toArray());

    }

    public function buildings(Request $request) {
        $searchTerm = null;
        $buildingQuery = DharmasalaBuilding::select('id','building_name as text');
        return $this->select2AjaxResponse($buildingQuery->get()->toArray());
    }

    public function floors(Request $request, DharmasalaBuilding $building) {
        $searchTerm = null;
        $floorQuery = DharmasalaBuildingFloor::select('id','floor_name as text')
                                                ->where('building_id',$building->getKey());

        return $this->select2AjaxResponse($floorQuery->get()->toArray());
    }

    public function rooms(Request $request, DharmasalaBuilding $building = null , DharmasalaBuildingFloor $floor = null) {

        $roomQuery = DharmasalaBuildingRoom::select('id', 'room_number as text');

        if ( $building ) {
            $roomQuery->where('building_id', $building->getKey());
        }
        if ($floor ) {
            $roomQuery->where('floor_id', $floor->getKey());
        }

        return $this->select2AjaxResponse($roomQuery->get()->toArray());
    }
}
