<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSadhakRegistration;
use App\Models\SibirRecord;
use App\Models\userLogin;
use App\Models\userDetail;
use App\Models\UserFamilyGroup;
class PublicEventGroupController extends Controller
{
    //
    public function index() {
        $my_sibirs = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                            ->where('sibir_record_id', '!=',NULL)
                                            ->get();
        return view( "public.user.group.index",compact('my_sibirs') );
    }

    public function add_family_to_event(Request $request, $event = null) {

        if (! $event ) {
            $events = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                        ->where('sibir_record_id', '!=',NULL)
                        ->with(["sibir_record"])
                        ->get();
            $single = false;
        } else {
            $events = SibirRecord::findOrFail(decrypt($event));
            $single = true;
        }
        return view("public.user.group.add_family_group",compact("events",'single'));
    }

    public function store_family_detail(Request $request) {
        
        // validation rule.

        // actual db action.

        $error_with = [];
        $error = false;
        $insert_data = [];
        $sibir_record = SibirRecord::findOrFail(decrypt($request->event));
        foreach ($request->login_id as $key=>$value) {
            $inertnal = [];
            // now lets verify if user
            // filter_var($request->username,FILTER_VALIDATE_EMAIL)/
            $is_email = filter_var($value,FILTER_VALIDATE_EMAIL);
            if ( $is_email ) {

                $user_login = userLogin::where('email',$is_email)
                                        ->first();
                $user_registration = UserSadhakRegistration::where('user_detail_id',($user_login) ? $user_login->user_detail_id : null)
                                                            ->where('sibir_record_id',$sibir_record->id)
                                                            ->first();
                
                //
                $check_record = UserFamilyGroup::where("sibir_record_id",$sibir_record->id)
                                                ->where(function ($query) use($user_login) {
                                                    return $query->where('leader_id',($user_login) ? $user_login->user_detail_id : null)
                                                                ->orWhere('member_id' , ($user_login) ? $user_login->user_detail_id : null); 
                                                })
                                                ->where("status",true)
                                                ->first();
                
                if ( ! $user_login ) {
                    $error_with[] = " `" .$value. "` email doesn't exists.";
                    $error = true;
                } elseif($is_email == auth()->user()->email) {
                    $error_with = "`".$is_email."` You cannot add yourself";
                    $error = true;
                } elseif( ! $user_registration ) {
                    $error_with[] = "`" . $value . "` is not register in the event {$sibir_record->sibir_title}.";
                    $error = true;
                } elseif( $check_record) {
                    $error_with[] = "`" . $value . "` is already in the family group.";
                    $error = true;
                }else {
                    $inertnal = [
                        "user_sadhak_registration_id" => $user_registration->id,
                        "sibir_record_id" => $sibir_record->id,
                        "leader_id" => auth()->user()->user_detail_id,
                        "member_id" => $user_login->userdetail->id,
                        "status" => true,
                        "relation" => $request->relation[$key],
                        "approved" => false,
                        "created_at" => \Carbon\Carbon::now(),
                        "updated_at" => \Carbon\Carbon::now(),
                        "link_type" => "email"
                    ];
                }
            } else {
                $current_user = userDetail::findOrFail(auth()->user()->user_detail_id);
                $user_detail = userDetail::where('phone_number',$value)
                                            ->where('phone_number', ' != ',$current_user->phone_number)
                                            ->first();
                // check if user is registered in given event.
                $user_registration = UserSadhakRegistration::where('user_detail_id',($user_detail) ? $user_detail->id : null)
                                                            ->where('sibir_record_id',$sibir_record->id)
                                                            ->first();
                if ( ! $user_detail ) {
                    $error_with[] = "`".$value . "` Login ID Doesn't exists.";
                    $error = true;
                } elseif($value == $current_user->phone_number){
                    $error_with = "You cannot add yourself.";
                    $error = true;
                } elseif ( ! $user_registration ) {
                    $error_with[] = "`" . $value . "` is not register in the event {$sibir_record->sibir_title}.";
                    $error = true;
                } else {
                    $inertnal = [
                        "user_sadhak_registration_id" => $user_registration->id,
                        "sibir_record_id" => $sibir_record->id,
                        "leader_id" => auth()->user()->user_detail_id,
                        "member_id" => $user_detail->id,
                        "status" => true,
                        "relation" => $request->relation[$key],
                        "approved" => false,
                        "created_at" => \Carbon\Carbon::now(),
                        "updated_at" => \Carbon\Carbon::now(),
                        "link_type" => "phone"
                    ];
                }
            }

            if ($inertnal && ! empty($inertnal) ) {
               array_push($insert_data,$inertnal);
            }

        }
        if($error) {
            return response([
                'success' => false,
                'message' => "Please fix following error.",
                'data' => $error_with
            ]);
        }

        try {
            UserFamilyGroup::insert($insert_data);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return response([
                "success" => false,
                "message" => "Something went wrong. Please try again later." . $th->getMessage()
            ]);
        }

        return response([
            "success" => true,
            "message" => "Your family detail has been added."
        ]);
    }

    public function family_list_search(Request $request) {
        $request->validate([
            "year" => "required|date_format:Y",
            "record_type" => "required|in:my-group,other-group",
            "event" => "required"
        ]);

        // now let's search event.
        $event_detail = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                                ->where("sibir_record_id",decrypt($request->event))
                                                ->first();
        if ( ! $event_detail ) {
            return response([
                "success" => false,
                "message" => 'Record invalid.'
            ]);
        }
        if ($request->record_type == "my-group")
        {
            $members = UserFamilyGroup::where('leader_id',auth()->user()->user_detail_id)
                                        ->where('sibir_record_id',$event_detail->sibir_record_id)
                                        ->get();
        }

        if ($request->record_type == "other-group")
        {
            $members = UserFamilyGroup::where('member_id',auth()->user()->user_detail_id)
                                        ->where('sibir_record_id',$event_detail->sibir_record_id)
                                        ->get();
        }

        return view("public.user.group.partials.list_member",compact("members","event_detail"));
    }

    public function remove_member(Request $request, $group_id) {
        $check_authorized = UserFamilyGroup::where('leader_id',auth()->user()->user_detail_id)
                                            ->where('id',decrypt($group_id))
                                            ->first();
        if ( ! $check_authorized ) {
            if ( $request->ajax() ) {
                return response([
                    "success" => false,
                    'message' => "You are not authorized to perform this action."
                ]);
            }
            $request->session()->flash('message',"You are not authorized to remove perform this action.");
            return back();
        }

        //
        try {
            $check_authorized->delete();
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response([
                    'success' => false,
                    'message' => "Something went wrong."
                ]);

                $request->session()->flash('message',"Something went wrong.");
                return back();
            }
        }

        if ($request->ajax() ) {
            return response([
                "success" => true,
                'message' => "Selected Member successfully removed."
            ]);
        }
        $request->session()->flash('success',"Selected Member successfully removed.");
        return back();
    }

    public function remove_yourself(Request $request, $group_id) {
        $check_authorized = UserFamilyGroup::where('member_id',auth()->user()->user_detail_id)
                                            ->where('id',decrypt($group_id))
                                            ->first();
        if ( ! $check_authorized ) {
            if ( $request->ajax() ) {
                return response([
                    "success" => false,
                    'message' => "You are not authorized to perform this action."
                ]);
            }
            $request->session()->flash('message',"You are not authorized to remove perform this action.");
            return back();
        }

        //
        try {
            $check_authorized->delete();
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response([
                    'success' => false,
                    'message' => "Something went wrong."
                ]);

                $request->session()->flash('message',"Something went wrong.");
                return back();
            }
        }

        if ($request->ajax() ) {
            return response([
                "success" => true,
                'message' => "You have removed yourself from family group."
            ]);
        }
        $request->session()->flash('success',"You have removed yourself from family group.");
        return back();
    }

    public function edit_member(Request $request, $id) {
        $request->validate([
            "status" => "required|boolean",
            "relation" => "required"
        ]);

        $detail = UserFamilyGroup::where('leader_id',auth()->user()->user_detail_id)
                                    ->where('id',decrypt($id))
                                    ->first();
        if (! $detail ) {
            if ($request->ajax() ) {
                return response([
                    'success' => false,
                    'message' => "You are not authorized to perform this action."
                ]);

                $request->session()->flash('message',"You are not authorized to perform this action.");
                return back();
            }
        }

        $detail->status = $request->status;
        $detail->relation = $request->relation;

        try {
            if ($detail->isDirty() ) {
                $detail->save();
            }
        } catch (\Throwable $th) {
            //throw $th;

            if ( $request->ajax() ) {
                return response([
                    "success" => false,
                    "message" => "Something went to wrong. Unable to complete action."
                ]);
            }

            $request->session()->flash('message',"Something went wrong. Unable too complete action.");
            return back()->withInput();
        }

        if ( $request->ajax() ){ 
            return response([
                "success" => true,
                "message" => "Record updated successfully."
            ]);
        }

        $request->session()->flash('success',"Record updated Successfully.");
        return back();
    }
}
