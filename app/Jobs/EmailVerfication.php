<?php

namespace App\Jobs;

use App\Classes\Helpers\Str;
use App\Mail\Member\EmailVerification;
use App\Models\Member;
use App\Models\MemberVerification;
use Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailVerfication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?Member $member;
    protected  ?String $email = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(?Member $member, ?String $email)
    {
        $this->member = $member;
        $this->email = $email;
    }

    public function set(mixed $value)
    {
        if ($value instanceof  Member) {
            $this->member = $value;
            return;
        }

        $this->email = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->member?->email ?? $this->email)->send(new EmailVerification($this->member, $this->otpProcess()));
    }

    /**
     * Save otp code in db, and return otp string.
     * @return string
     */

    public function otpProcess(): string
    {
        $otp = Str::generateOtp($this->member);

        if ($this->email) {

            MemberVerification::where('validation_name', $this->email)->delete();
        }

        $memberVerification = new MemberVerification();

        /**
         * @todo
         * Future Implementation. either use signature based verification link
         * or use Hash::make($otp) to encrypt the otp code in database.
         * 
         */

        $memberVerification->fill([
            'otp_code'  => site_settings('encrypt_all') ? Hash::make($otp) : $otp,
            //            'verification_link' => route('verification')
            'validation_name' =>  $this->email ?? null,
            'member_id' => $this->member?->getKey(),
            'data_type' => site_settings('encrypt_all') ? 'hashed' : 'raw'
        ]);

        $memberVerification->save();

        return $otp;
    }
}
