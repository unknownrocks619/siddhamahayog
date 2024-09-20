<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberDikshya;
use App\Models\UserSadhanaLevel;
use Illuminate\Http\Request;

class MemberSadhanaController extends Controller
{
    //

    public function add(Request $request, ?Member $member) {

        if ( $request->post() ) {
            
            $request->validate([
                'charan' => 'required',
                'upacharan' => 'required'
            ]);

            if (  ! $member ) {
                $request->validate(['member' => 'required','dikshya_type' => 'required']);
                $member = Member::find($request->post('member'));
            }
            
            // check if same charan and upacharan exists.
            $level = UserSadhanaLevel::where('charan_usl',$request->post('charan'))
                                        ->where('upacharan_usl',$request->post('upacharan'))
                                        ->where('user_id',$member->getKey())
                                        ->first();
            if ( $level) {
                return $this->json(false,'Charan & Upacharan Already Exists.');
            }

            $sadhanaLevel = new UserSadhanaLevel();
            $sadhanaLevel->fill([
                'charan_usl' => $request->post('charan'),
                'upacharan_usl' => $request->post('upacharan'),
                'charan_date_usl'   => $request->post('charan_date'),
                'upacharan_date_usl'    => $request->post('upacharan_date'),
                'user_id'   => $member->getKey(),
                'created_by_usl'    => auth()->guard('admin')->id()
            ]);
            
            if ( ! $sadhanaLevel->save() ) {
                return $this->json(false,'Unable to save Sadhana Level info');
            }

            return $this->json(true,'Sadhana level information has been updated.','reload');

        }

    }

    public function edit(Request $request, UserSadhanaLevel $sadhana, ?Member $member) {

        if ($request->post() ) {

            $sadhana->fill([
                'charan_usl' => $request->post('charan'),
                'upacharan_usl' => $request->post('upacharan'),
                'charan_date_usl'   => $request->post('charan_date'),
                'upacharan_date_usl'    => $request->post('upacharan_date'),
                'created_by_usl'    => auth()->guard('admin')->id()
            ]);

            if ( ! $sadhana->save() ) {
                return $this->json(false,'Unable to save.');
            }

            $sadhana->save();

            return $this->json(true,'Sadhana Information Updated.','reload');
        }
    }

    public function delete(UserSadhanaLevel $sadhana, ?Member $member) {
        if ( ! $sadhana->delete() ) {
            return $this->json(false,'Unable to remove sadhana information.');
        }
        return $this->json(true,'Sadhana information has been removed.','reload');
    }
}
