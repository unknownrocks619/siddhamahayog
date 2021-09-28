<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\userDetail;
use App\Models\userReference;

class UserReferencesController extends Controller
{
    //

    public function update_user_references(Request $request){

        $user_detail = userDetail::findOrFail($request->user_id);
        $user_reference_detail = userReference::where('user_detail_id',$request->user_id)->first();
        $response = [];
        if ( ! $user_reference_detail ){

            $referenceModel = new userReference;
            $referenceModel->created_by_user = Auth::user()->id;
            $referenceModel->user_detail_id = $request->user_id;
            if((int) $request->refered_by_person) {
                $user_detail = userDetail::findOrFail($request->refered_by_person);
                $referenceModel->name = $user_detail->full_name();
                $referenceModel->phone_number = $user_detail->phone_number;
            } else {
                $referenceModel->name = $request->refered_by_person;
            }

            if ($request->refered_center) {
                $referenceModel->center_id = $request->refered_center;
            }

            if($referenceModel->save()){
                $response = [
                    'success'=>true,
                    'message' => "User Reference has been added."
                ];
            } else{
                $response = [
                    'success'=>false,
                    'message' => "Oops, Unable to add user references."
                ];
            }
        } else{
            
            if($request->refered_center) {
                $user_reference_detail->center_id = $request->refered_center;
            }

            if((int) $request->refered_by_person) {
                $user_detail = userDetail::findOrFail($request->refered_by_person);
                $user_reference_detail->name = $user_detail->full_name();
                $user_reference_detail->phone_number = $user_detail->phone_number;
            } else {
                $user_reference_detail->name = $request->refered_by_person;
            }


            if ($user_reference_detail->save()){
                $respose = [
                    'success' => true,
                    'message' => "User Reference index has been updated."
                ];
            } else{
                $response = [
                    'success' => false,
                    'message' => "Oops, Unable to update user reference index. "
                ];
            }
        }

        // if($request->ajax()){
            return response ($response);
        // }
    }
}
