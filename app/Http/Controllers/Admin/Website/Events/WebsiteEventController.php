<?php

namespace App\Http\Controllers\Admin\Website\Events;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadHandler;
use App\Models\WebsiteEvents;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebsiteEventController extends Controller
{
    use UploadHandler;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $events = WebsiteEvents::with(["event_program"])->get();
        return view('admin.website.events.index',compact("events"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.website.events.add');
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
        $request->validate([
            "event_title" => "required",
            "event_type" => "required|in:offline,online,live",
            "event_short_description" => "required",
            "event_start_date" => "required",
            "event_end_date" => "required",
            "event_phone_contact" => "required",
            "event_contact_person" => "required",
            "page_header_image" => "required"
        ]);

        // dd($request->all());
        $events = new WebsiteEvents;
        $events->event_title = $request->event_title;
        $events->slug = Str::slug($request->event_title);
        $events->event_type = $request->event_type;
        $events->short_description = $request->event_short_description;
        $events->full_description = $request->event_description;

        $this->set_upload_path("website/event");


        $images = [];
        if ($request->hasFile("featured_image_one") ) {
            $images ["one"] = $this->upload($request,"featured_image_one");
        }
        if ($request->hasFile("featured_image_two") ) {
            $images ["two"] = $this->upload($request, "featured_image_two");
        }
        if ($request->hasFile("featured_image_three")) {
            $images["three"] = $this->upload($request,"featured_image_three");
        }
        $events->featured_image = json_encode($images);

        /**
         * Carbon
         */
        $carbon_event_start_date = \Carbon\Carbon::parse($request->event_start_date);
        $carbon_event_end_date = \Carbon\Carbon::parse($request->event_end_date);

        $today = \Carbon\Carbon::now();
        $status = ($carbon_event_start_date->gt($today)) ? "upcoming" : null;
        
        if ( ! $status ) {
            $status = ($carbon_event_end_date->lt($today)) ? "completed" : null;
            $events->completed = true;
        }

        if ( ! $status ) {
            $status = $carbon_event_start_date->between($today,$carbon_event_end_date) ? "ongoing" : "pending";
        }

        $events->status = $status;

        // dd($carbon_event_start_date->format("Y-m-d H:i:s"));
        $events->event_start_date = $carbon_event_start_date->format("Y-m-d H:i:s");
        $events->event_start_time = $carbon_event_start_date->format("H:i:s");
        $events->event_end_date = $carbon_event_end_date->format("Y-m-d H:i:s");
        $events->event_end_time = $carbon_event_end_date->format("H:i:s");

        $events->event_contact_person = $request->event_contact_person;
        $events->event_contact_phone = $request->event_phone_contact;
        $page_image = [];
        if ($request->hasFile('page_header_image') ) {
            $page_image["header"] = $this->upload($request,"page_header_image");
        }

        if ($request->hasFile('page_image') ) {
            $page_image['page_image'] = $this->upload($request,"page_image");
        }
        $events->full_address  = $request->event_location;
        $events->google_map_link = $request->google_map;
        $events->page_image = json_encode($page_image);
        
        try {
            $events->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("error","Unable to create event. Error: ". $th->getMessage());
            return back();
        }
        $request->session()->flash("success","New Event Created.");
        return back();
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
     * @param  WebsiteEvents  $event
     * @return \Illuminate\Http\Response
     */
    public function edit( WebsiteEvents $event)
    {
        //
        $featured_image = ($event->featured_image) ? json_decode($event->featured_image) : null;
        $page_image = ($event->page_image) ? json_decode($event->page_image) : null;
        return view('admin.website.events.edit',compact('event','featured_image','page_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebsiteEvents $event)
    {
        //
        // dd($request->all());
        $event->event_title = $request->event_title;
        if ($event->isDirty("event_title") ) {
            $event->slug = Str::slug($request->event_title);
        }
        $event->event_type = $request->event_type;
        $event->short_description = $request->event_short_description;
        $event->full_description = $request->event_description;

        $this->set_upload_path("website/events");
        $featured_image = json_decode($event->featured_image);
        $images = [];

        if ($request->hasFile("featured_image_one") ) {
            $images ["one"] = $this->upload($request,"featured_image_one");
        } elseif($featured_image && isset($featured_image->one) ) {
            $images["one"] = (array) $featured_image->one;
        }
        if ($request->hasFile("featured_image_two") ) {
            $images ["two"] = $this->upload($request, "featured_image_two");
        } elseif($featured_image && isset($featured_image->two) ) {
            $images["two"] = (array) $featured_image->two;
        }

        if ($request->hasFile("featured_image_three")) {
            $images["three"] = $this->upload($request,"featured_image_three");
        } elseif($featured_image && isset($featured_image->three) ) {
            $images["three"] = (array) $featured_image->three;
        }

        $event->featured_image = json_encode($images);
        /**
         * Carbon
        */
        $carbon_event_start_date = \Carbon\Carbon::parse($request->event_start_date);
        $carbon_event_end_date = \Carbon\Carbon::parse($request->event_end_date);

        $today = \Carbon\Carbon::now();
        $status = ($carbon_event_start_date->gt($today)) ? "upcoming" : null;
        
        if ( ! $status ) {
            $status = ($carbon_event_end_date->lt($today)) ? "completed" : null;
            $event->completed = true;
        }

        if ( ! $status ) {
            $status = $carbon_event_start_date->between($today,$carbon_event_end_date) ? "ongoing" : "pending";
        }

        $event->status = $status;

        // dd($carbon_event_start_date->format("Y-m-d H:i:s"));
        $event->event_start_date = $carbon_event_start_date->format("Y-m-d H:i:s");
        $event->event_start_time = $carbon_event_start_date->format("H:i:s");
        $event->event_end_date = $carbon_event_end_date->format("Y-m-d H:i:s");
        $event->event_end_time = $carbon_event_end_date->format("H:i:s");

        $event->event_contact_person = $request->event_contact_person;
        $event->event_contact_phone = $request->event_phone_contact;

        $page_image = [];
        $page_prev_image = json_decode($event->page_image);

        if ($request->hasFile('page_header_image') ) {
            $page_image["header"] = $this->upload($request,"page_header_image");
        } elseif ($page_prev_image && isset($page_prev_image->header) ) {
            $page_image["header"] = (array) $page_prev_image->header;
        }

        if ($request->hasFile('page_image') ) {
            $page_image['page_image'] = $this->upload($request,"page_image");
        } elseif($page_prev_image && isset($page_prev_image->page_image) )  {
            $page_image["page_image"] = (array) $page_prev_image->page_image;
        }


        $event->full_address  = $request->event_location;
        $event->google_map_link = $request->google_map;
        $event->page_image = json_encode($page_image);
        try {
            $event->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("error","Unable to update event. Error: ". $th->getMessage());
            return back();
        }

        $request->session()->flash("success","Event detail updated.");
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebsiteEvents $event)
    {
        //
        try {
            $event->delete();
        } catch (\Throwable $th) {
            //throw $th;
            request()->session()->flash('error',"Unable to delete event. Please Try again. Error: " . $th->getMessage());
            return back();
        }

        request()->session()->flash("success","Event Deleted.");
        return back();

    }
}
