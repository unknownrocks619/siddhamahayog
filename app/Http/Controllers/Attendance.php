<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SadhakUniqueZoomRegistrationArchive;

use App\Models\EventVideoAttendance;

class Attendance extends Controller {

    public function index() {
        // canada session
        return $this->canada();
    }

    protected function canada() {
        $get_all_meeting_record = EventVideoAttendance::where('source',"zonal")
                                    ->where('zonal_setting_id',2)
                                    ->with(["user_detail"])
                                    ->limit(20)
                                    ->get()
                                    ->groupBy("user_id");
        // dd($get_all_meeting_record);
        return view('canada',compact("get_all_meeting_record"));
        
    }


 }