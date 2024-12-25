<?php

namespace App\Classes\Helpers;

use App\Models\Member;
use App\Models\MemberVerification;

class Str
{
    /**
     * @param $model
     * @return string
     */
    public static function uuid($model=null): string {
        $uuid = \Illuminate\Support\Str::uuid();
        $toArray = explode('-',$uuid);
        $finalString = $toArray[count($toArray)-1];

        if ($model && $model->getKey() ) {
            $finalString = $finalString.'-'.$model->getKey();
        }

        return $finalString;
    }

    /**
     * Return Unique 8 Digit Otp Code for user.
     * @param Member|null $member
     * @return string
     */
    public static function generateOtp(?Member $member) : string {
        $otpCode = strtoupper(\Illuminate\Support\Str::random(8));

        // delete if there was any previous otp code for this member. we don't want these kind
        // of data floating everywhere.

        if ( $member ) {
            MemberVerification::where('member_id',$member->getKey())->delete();
        }

        $isUnique = false;

        do {

            if ( ! MemberVerification::where('otp_code',$otpCode)->exists() ) {
                $isUnique = true;
            } else {
                $otpCode = strtoupper(\Illuminate\Support\Str::random(8));
            }
        } while ( ! $isUnique );

        return $otpCode;
    }
}
