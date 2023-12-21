<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use Illuminate\Http\Request;

class MemberEmergencyController extends Controller
{
    //

    public function add(Request $request, Member $member) {

        if ($request->post() ) {

            $request->validate(['full_name' => 'required']);

            $memberEmergency = new MemberEmergencyMeta();

            $memberEmergency->fill([
                'member_id' => $member->getKey(),
                'contact_person' => $request->post('full_name'),
                'relation'  => $request->post('relation'),
                'phone_number'  => $request->post('phone_number'),
                'contact_type'  => $request->post('contact_type'),
            ]);

            if (! $memberEmergency->save() ) {
                return $this->json(false,' Unable to save emergency contact info.');
            }

            return $this->json(true,'Emergency contact information created.');
        }
    }

    public function delete(Request $request, MemberEmergencyMeta $emergencyMeta) {

        if (! $emergencyMeta->delete() ) {
            return $this->json(false,'Unable to delete emergency Contact Info');
        }

        return $this->json(true,'Contact Information deleted.','reload');

    }
}
