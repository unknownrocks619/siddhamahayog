<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


use App\Models\userDetail;
use App\Models\UserVerification;

class UserVerificationController extends Controller
{
    //

    public function update(Request $request){
        $userDetail = UserDetail::findOrFail($request->get('user_id'));
        $post_content = $request->post();
        $path = $request->file('document_file')->store('documents');
        $file = $request->file('document_file');
        $file_detail = [
            "path" => $path,
            'orignal_name' => $file->getClientOriginalName(),
            'extension' => $file->extension(),
        ];
        $post_content["document_file_detail"] = json_encode($file_detail);
        $post_content['user_detail_id'] = $userDetail->id;
        $post_content['verification_type'] = $request->document_type;

        $post_content['parent_name'] = $request->post('gaurdian_name');
        $post_content['parent_phone'] = $request->gaurdian_phone;
    
        if (Auth::check() )
        {
            $post_content['created_by_user'] = Auth::user()->id;
            $post_content["verified"] = true;
        }

        // first find out if there was already an entry about this user ?
        $user_verification_row = UserVerification::where('user_detail_id',$userDetail->id)->first();

        if ($user_verification_row) {
            $user_verification_row->verification_type = $post_content['verification_type'];
            $user_verification_row->document_file_detail = $post_content["document_file_detail"];
            $user_verification_row->parent_name = $post_content['parent_name'];
            $user_verification_row->parent_phone = $post_content['parent_phone'];

            $user_verification_row->verified = true;
            $user_verification_row->save();

            if($request->ajax()){
                return response([
                    'success' => true,
                    'message' => "User verification status updated."
                ]);
            }
            $request->session()->flash("success",'User verification status updated.');
            return back();
        }


        // $verificationModel = new 
        UserVerification::create($post_content);

        // act according to user entry type.
        if (Auth::check() )
        {
            if ( $request->ajax() ) {
                return response([
                    'success' => true,
                    'message' => "Congratulation, User has been verified."
                ]);
            }
            $request->session()->flash('success',"Congratulation, User has been verified.");
            return back();
        }
    }
}
