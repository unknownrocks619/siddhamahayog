<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\DharmasalaAmenity;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmenitiesController extends  Controller
{
    public function index() {
        $amenitites = DharmasalaAmenity::get();
        return view('admin.dharmasala.amenity.index',['amenities' => $amenitites]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'  => 'required'
        ]);

        // check for duplicate name.
        if ( DharmasalaAmenity::where('slug',str($request->post('name'))->slug())->exists() ){
            return $this->json(false,'Amenity Already exists.');
        }

        $amenity = new DharmasalaAmenity();
        $amenity->fill([
            'amenity_name' => $request->post('name'),
            'slug'  => str($request->post('name'))->slug()->value(),
            'icon'  => strip_tags($request->post('icon'))
        ]);
        
        if ( ! $amenity->save() ) {
            return $this->json(false,'Unable to save amenity information.');
        }

        return $this->json(true,'Amenity Saved.','reload');
    }

    public function edit(Request $request, DharmasalaAmenity $amenity) {

        if ($request->post() ) {
            return $this->udpate($request,$amenity);
        }

        return view('admin.dharmasala.amenity.edit',['amenity' => $amenity]);
    }

    public function udpate(Request $request, DharmasalaAmenity $amenity) {

        $request->validate([
            'name'  => 'required'
        ]);

        // check for duplicate name.
        if ( DharmasalaAmenity::where('slug',str($request->post('name'))->slug())->where('id','!=',$amenity->getKey())->exists() ){
            return $this->json(false,'Amenity Already exists.');
        }
        
        $amenity->fill([
            'amenity' => $request->post('name'),
            'slug'  => str($request->post('name'))->slug(),
            'icon'  => $request->post('icon')
        ]);
        
        if ( ! $amenity->save() ) {
            
            return $this->json(false, "Unable to update Amenity Information.");
        }

        return $this->json(true,'Amenity Information Updated.');
    }

    public function delete(DharmasalaAmenity $amenity) {
        
        // first delete in room and than delete amenity.
        try {

            DB::transaction(function() use ($amenity) {

                foreach ($amenity->rooms() as $room) {
                    $roomAmenity = collect($room->amenities)->filter(fn($item)=>$item!=$amenity->getKey());
                    
                    $room->amenities = $roomAmenity->toArray();
                    $room->save();
                }
    
                $amenity->delete();
            });

        } catch (Error $error) {
            return $this->json(false,'Unable to delete amenity. Error: '. $error->getMessage());
        }

        return $this->json(true,'Amenity Deleted.','reload');
    }
}
