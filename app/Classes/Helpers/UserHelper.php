<?php

namespace App\Classes\Helpers;


use App\Models\Member;
use App\Models\MemberVerification;

trait UserHelper
{
    /**
     * @param Member $member
     * @param string $country_code
     * @return string
     */
    public function isCountry(string $country_code='NP'): string {
        if ( ! $this->countries &&  $country_code != $this->country) {
            return false;
        }

        return strtolower($member->countries?->code ?? '') == strtolower($country_code);
    }

    /**
     * @param string $type
     * @return void
     */
    public function otpModel(string $type = 'email') : void {
        $userVerificationCode = new MemberVerification();
        $userVerificationCode->fill([
            'member_id' => $this->getKey(),
            'otp_code' => Str::generateOtp($this),
            'type'  => $type
        ]);

        $userVerificationCode->save();
    }

    /**
     * @param string $otp
     * @param string|null $email
     * @return bool
     */
    public function verifyOtp(string $otp, ?string $email=null): bool {

        // if no email or no id we can't just otp..
        if ( ! $email && ! $this->getKey() ) {
            return false;
        }

        if ( ! $this->getKey() ) {
            $member = Member::where('email',$email)->first();
        } else {
            $member = $this;
        }

        if ( ! $member?->getKey()) {
            return false;
        }

        $verificationCode = MemberVerification::where('member_id', $member->getKey())->where('otp_code', $otp)->first();

        if ( ! $verificationCode ) {
            return false;
        }

        if ($verificationCode->type == 'email') {
            $member->is_email_verified = true;
        }

        if ($verificationCode->type == 'phone') {
            $member->is_phone_verified = true;
        }

        if ($member->isDirty(['is_email_verified','is_phone_verified'])) {
            $member->save();
        }

        $verificationCode->delete();
        return true;


    }

    /**
     * @param Member|string|null $member
     * @return string
     */
    public function getOtp(Member|string|null $member): string {

        if (is_string($member) ) {
            $member = Member::where('email',$member)->first();
        }

        if ( ! $member ) {
            $member = $this;
        }

        if ( ! $member?->getKey() ) {
            return '';
        }

        $otpCode = MemberVerification::where('member_id',$member->getKey())->latest()->first();

        if ( ! $otpCode ) {
            return '';
        }

        return $otpCode->otp_code;
    }
}
