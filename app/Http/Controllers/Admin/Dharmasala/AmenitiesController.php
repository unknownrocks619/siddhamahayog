<?php

namespace App\Http\Controllers\Admin\Dharmasala;

use App\Http\Controllers\Controller;
use App\Models\DharmasalaAmenity;
use Illuminate\Http\Request;

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
            'amenity' => $request->post('name'),
            'slug'  => str($request->post('name'))->slug()
        ]);

        if ( ! $amenity->save() ) {
            return $this->json(false,'Unable to save amenity information.');
        }

        return $this->json(true,'Amenity Saved.','reload');
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
            'slug'  => str($request->post('name'))->slug()
        ]);
        
        if ( ! $amenity->save() ) {
            return $this->json(false, "Unable to update Amenity Information.");
        }

        return $this->json(true,'Amenity Information Updated.');
    }
}
