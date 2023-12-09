<?php

namespace App\Http\Controllers\Sadhak;

use App\Http\Controllers\Controller;
use App\Models\Sadhak\MemberToSadhak;
use App\Models\Sadhak\SadhakMember;
use App\Models\ZoomAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberJoinController extends Controller
{
    //

    public function joinAsAdmin()
    {
        $checkRecord = MemberToSadhak::where('member_id', auth()->id())
            ->where('join_type', 'admin')->first();

        $getAdminLink = DB::connection('sadhak')->table('zoom_settings')->find('5');

        if (!$checkRecord) {

            $insertRecord = new MemberToSadhak();
            $insertRecord->member_id = auth()->id();
            $insertRecord->join_type = 'admin';
            $insertRecord->join_link = $getAdminLink->admin_start_url; //generate join link
            $insertRecord->joinHistory = [
                [
                    'ip' => request()->ip(),
                    'browser' => request()->header('User-Agent')
                ]
            ];
            $insertRecord->save();

            return redirect()->to($getAdminLink->admin_start_url);
        }

        $record = $checkRecord->joinHistory;
        $record[] = [
            'ip' => request()->ip(),
            'browser' => request()->header('User-Agent')
        ];
        $checkRecord->joinHistory = $record;

        $checkRecord->save();
        return redirect()->to($checkRecord->join_link);
    }

    public function sadhakJoin()
    {
        $checkRecord = MemberToSadhak::where('member_id', auth()->id())
            ->where('join_type', 'sadhak')->first();

        if ( $checkRecord ) {

            $record = $checkRecord->joinHistory;
            $record [] = [
                'ip' => request()->ip(),
                'browser' => request()->header('User-Agent')
            ];

            $checkRecord->joinHistory = $record;
            $checkRecord->save();
            return redirect()->to($checkRecord->join_link);

        }

        $getAdminLink = DB::connection('sadhak')->table('zoom_settings')->find('5');
        $zoom_account = ZoomAccount::find(2);
        $zoom_link = json_decode(register_participants($zoom_account, $getAdminLink->meeting_id));
        if (isset($zoom_link->join_url)) {

            $insertRecord = new MemberToSadhak();
            $insertRecord->member_id = auth()->id();
            $insertRecord->join_type = 'sadhak';
            $insertRecord->join_link = $zoom_link->join_url; //generate join link
            $insertRecord->joinHistory = [
                [
                    'ip' => request()->ip(),
                    'browser' => request()->header('User-Agent')
                ]
            ];
            $insertRecord->save();

            return redirect()->to($zoom_link->join_url);
        }

        session()->flash('error', 'Unable to join Session Please Contact Support. Error ' . $zoom_link->code);
        return back();
    }
}
