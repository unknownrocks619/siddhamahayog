<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\userDetail;
use App\Models\Room;
use App\Models\Booking;
use App\Models\OfflineVideo;
use App\Models\Questions;
use App\Models\QuestionCollection;
use App\Models\UserAnswer;
use App\Models\UserFamilyGroup;
use App\Models\EventVideoClass;
use App\Models\ZoomSetting;

class ModalController extends Controller
{
    //
    public $access = null;
    public $modals = [
        'add_user_email_modal' => 'partials.user_detail_email_add_modal',
        'user_maritial_modal' => 'partials.user_maritial_modal',
        'user_petname_modal' => 'partials.user_detail_petname_add_modal',
        'user_reference_modal' => 'partials.user_detail_reference_add_modal',
        'room_delete_confirmation_modal' => 'partials.room_delete_confirmation',
        'display_user_detail_booking' => 'partials.user_detail_profile',
        'user_webcam_display' => "partials.user_webcam_image",
        'cancel_reservation_policy' => 'partials.cancel_user_reservation',
        'check_out_logged_visitor' => 'partials.check_out_visitor',
        'assign_sewa_to_user' => 'partials.assign_sewa_to_visitor',
        'user_verification_modal' => 'partials.user_verification',
        'donation_modal' => 'partials.donations',
        'youtube_modal' => 'partials.youtube',
        'edit-question' => "partials.question_edit",
        'view-result' => "partials.view-marks",
        'subjective-answer' => "partials.subjective_answer_view",
        'objective-answer' => 'partials.objective_answer_view',
        'group-leader-update-member' => 'partials.edit-group-detail',
        'start-zoom-session' => 'partials.attendance-my-group',
        'start-zoom-session-zonal' => 'partials.attendance-my-group-zonal'

    ];

    public $modal_access = [
        'add_user_email_modal' => ['admin'],
        'user_petname_modal' => ['admin'],
        'user_maritial_modal' => ['admin'],
        'user_reference_modal' => ['admin'],
        'room_delete_confirmation_modal' => ['admin'],
        'display_user_detail_booking' => ['admin'],
        'user_webcam_display' => ['admin','centers'],
        'cancel_reservation_policy' => ['admin'],
        'check_out_logged_visitor' => ['admin'],
        'assign_sewa_to_user' => ['admin'],
        'user_verification_modal' => ['admin'],
        'donation_modal' => ['admin','centers'],
        'youtube_modal' => ['public'],
        "edit-question" => ['admin'],
        'view-result' => ['public'],
        "subjective-answer" => ["admin"],
        "objective-answer" => ["admin"],
        'group-leader-update-member' => ["public"],
        "start-zoom-session" => ["public"],
        "start-zoom-session-zonal" => ["public"]
    ];
    public function modal(Request $request) {
        $data = [];
        if( Auth::check() ) {
            $this->access = isAdmin() ? "admin" : (isCenter() ? "centers" : "public");
                if ($request->user_detail_id){
                    $user_detail = userDetail::findOrFail($request->user_detail_id);
                    $data['user_detail'] = $user_detail;    
                }    
            

            if ($request->reference && $request->reference_id ){
                
                switch ($request->reference) {
                    case 'Room':
                        # code...
                        $modalRecord = Room::findOrFail($request->reference_id);
                        break;
                    case "Booking":
                        $modalRecord = Booking::findOrFail($request->reference_id);
                        break;
                    case "Offline":
                        $modalRecord = OfflineVideo::findOrFail(decrypt($request->reference_id));
                        break;
                    case "question":
                        $modalRecord = Questions::findOrFail($request->reference_id);
                        break;
                    case "q_collection":
                        $modalRecord = QuestionCollection::findOrFail(decrypt($request->reference_id));
                        break;
                    case "answer":
                            $modalRecord = UserAnswer::findOrFail($request->reference_id);
                            break;
                    case "group_member":
                            $modalRecord = UserFamilyGroup::findOrFail(decrypt($request->reference_id));
                            break;
                    case "live_session":
                            $modalRecord = EventVideoClass::find(decrypt($request->reference_id));
                            dd(($request->reference_id));
                            break;
                    case "live_session_zonal":
                            $modalRecord = ZoomSetting::findOrFail(decrypt($request->reference_id));
                            break;
                    default:
                        # code...
                        break;
                }

                // if ($request->reference == "Room"){
                //     $modalRecord = Room::findOrFail($request->reference_id);                    
                // }

                
                $data["record"] = $modalRecord;
            }
        }
        if ( ! array_key_exists($request->modal,$this->modals) )
        {
            abort(404);
        }
        if ($this->is_allowed($request->modal) ) {
            
            return view($this->access.".".$this->modals[$request->modal],$data);
        }
        // return view($this->access.".".$this->modals[$request->modal],$data);
        return view("public.partials.unauthorized");
        abort(403);

    }

    private function is_allowed($page){
        return in_array($this->access,$this->modal_access[$page]) ? true : false ;
    }

}
