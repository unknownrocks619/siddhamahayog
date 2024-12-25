<?php

namespace App\Mail\Member;

use App\Models\Member;
use Cloudinary\Api\Metadata\Validators\StringLength;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    public ?Member $member;
    protected string $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(?Member $member, String $otp)
    {
        //
        $this->member = $member;
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Email Verification',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.user.email-verification',
            with: ['member' => $this->member,'otpCode' => $this->otp]
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
