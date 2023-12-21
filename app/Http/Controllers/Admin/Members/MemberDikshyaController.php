<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberDikshya;
use Illuminate\Http\Request;

class MemberDikshyaController extends Controller
{
    //

    public function add(Request $request, ?Member $member) {

        if ( $request->post() ) {

            if (  ! $member ) {
                $request->validate(['member' => 'required','dikshya_type' => 'required']);
                $member = Member::find($request->post('member'));
            }

            $memberDikshya = MemberDikshya::where('member_id','=',$member->getKey())
                                            ->where('dikshya_type',$request->post('dikshya_type'))
                                            ->first();
            if (! $memberDikshya ) {
                $memberDikshya = new MemberDikshya;

                $memberDikshya->fill([
                    'dikshya_type'  => $request->post('dikshya_type'),
                    'ceromony_location' => $request->post('location') ?? '-',
                    'ceromony_date' => $request->post('dikshya_date') ?? '-',
                    'guru_name' => $request->post('dikshya_name') ?? '-',
                    'member_id' => $member->getKey()
                ]);


                if ( ! $memberDikshya->save() ) {
                    return $this->json(false,'Unable to save dikshya information');
                }

                return $this->json(true,'Dikshya information has been updated.','reload');
            }

        }

    }

    public function edit(Request $request, MemberDikshya $dikshya, ?Member $member) {

        if ($request->post() ) {
            $dikshya->fill([
                'dikshya_type'  => $request->post('dikshya_type'),
                'ceromony_location' => $request->post('location') ?? '-',
                'ceromony_date' => $request->post('dikshya_date') ?? '-',
                'guru_name' => $request->post('dikshya_name') ?? '-'
            ]);

            if ( ! $dikshya->save() ) {
                return $this->json(false,'Unable to save.');
            }
            $dikshya->save();

            return $this->json(true,'Dikshya Information Updated.','reload');
        }
    }

    public function delete(MemberDikshya $dikshya, ?Member $member) {
        if ( ! $dikshya->delete() ) {
            return $this->json(false,'Unable to remove dikshya information.');
        }
        return $this->json(true,'Dikshya information has been removed.','reload');
    }
}
