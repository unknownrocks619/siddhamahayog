<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Admin\Dharmasala\BookingController;
use App\Http\Controllers\Controller;
use App\Models\ImageRelation;
use App\Models\Images;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                'gotra'         => $request->post('gotra'),
                'verified_family'   => true,
            ]);

            if (! $memberEmergency->save() ) {
                return $this->json(false,' Unable to save emergency contact info.');
            }

            return $this->json(true,'Emergency contact information created.','reload');
        }
    }

    public function delete(Request $request, MemberEmergencyMeta $emergencyMeta) {

        if (! $emergencyMeta->delete() ) {
            return $this->json(false,'Unable to delete emergency Contact Info');
        }

        return $this->json(true,'Contact Information deleted.','reload');

    }

    public function bulkInsert(Request $request, Member $member) {
        $request->validate([
            'contact_person.*' => 'required',
            'relation.*'    => 'required',
            'gotra.*'   => 'required',
            'phone_number.*'  => 'required',
            'dikshya_type.*' => 'required',
        ]);

        $memberToInclude = [];

        foreach ($request->post('full_name') ?? [] as $key => $full_name)  {


            $familyMember = MemberEmergencyMeta::where('phone_number', $request->post('phone_number')[$key])
                                                ->where('contact_person',$full_name)
                                                ->where('member_id' , $member->getKey())
                                                ->where('contact_type','family')
                                                ->where('verified_family',true)
                                                ->where('relation', $request->post('relation')[$key])
                                                ->where('gotra',$request->post('gotra')[$key])
                                                ->first();
            /**
             * If Family doesn't exists create new instance.
             */
            if ( ! $familyMember ) {

                $familyMember = new MemberEmergencyMeta();
                $familyMember->fill([
                    'member_id' => $member->getKey(),
                ]);
            }

            $familyMember->gotra = $request->post('gotra')[$key];
            $familyMember->phone_number = $request->post('phone_number')[$key];
            $familyMember->relation  = $request->post('relation')[$key];
            $familyMember->contact_person = $full_name;
            $familyMember->contact_type = 'family';
            $familyMember->verified_family = true;
            $familyMember->dikshya_type = implode(',',$request->post('dikshya_type')[$key] ?? []);
            $familyMember->save();

            /**
             * Upload Profile Picture.
             */
            if (isset($request->file('family_photo')[$key]) && $request->file('family_photo')[$key] ) {

                $memberIDCard = Image::uploadImage($request->file('family_photo')[$key],$familyMember);
                if (isset ($memberIDCard[0]['relation'])) {

                    $memberCardType = $memberIDCard[0]['relation'];
                    $memberCardType->type = 'profile_picture';
                    $memberCardType->save();
                }

            }
            elseif ( isset($request->post('live_family_image')[$key]) && $request->post('live_family_image')[$key] ) {

                $isUrl = str($request->post('live_family_image')[$key])->contains('http');

                if ( $isUrl) {
                    $idMediaImage = $request->post('live_family_image')[$key];
                } else {
                    $idMediaImage = (new BookingController())->uploadMemberMedia($request,$request->post('live_family_image')[$key],'path');
                }

                $uploadImageFromUrl = Image::urlToImage($idMediaImage,'dharmasala-processing');

                if (! $uploadImageFromUrl instanceof  Images)  {
                    throw new \Error('Unable to verify Profile Image. Please try again or try uploading image.');
                }

                $imageRelation = (new ImageRelation())->storeRelation($familyMember,$uploadImageFromUrl);
                $imageRelation->type = 'profile_picture';
                $imageRelation->saveQuietly();

            }


            $memberToInclude[] = $familyMember->getKey();
        }

        $member->emergency()
                ->where('contact_type','family')
                ->whereNotIn('id',$memberToInclude)->delete();
    }

    public function uploadProfile(Request $request, Member $member, MemberEmergencyMeta $emergencyMeta) {

        $request->validate([
            'family_photo' => 'required'
        ]);

        if ($request->file('family_photo') ) {

            $memberIDCard = Image::uploadImage($request->file('family_photo'),$emergencyMeta);

            if (isset ($memberIDCard[0]['relation'])) {

                $memberCardType = $memberIDCard[0]['relation'];
                $memberCardType->type = 'profile_picture';
                $memberCardType->save();

            }

        }

        return $this->json(true,'Photo Uploaded','reload');
    }
}
