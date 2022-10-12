<?php

namespace App\Http\Requests\Frontend\Event;

use App\Http\Traits\CourseFeeCheck;
use App\Models\MemberNotification;
use Illuminate\Foundation\Http\FormRequest;

class LiveEventRequest extends FormRequest
{
    use CourseFeeCheck;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $access = false;
        $access = auth()->check() ? true : false;

        $access =  ($this->isPaid()) ? true : false;
        return $access;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function isPaid()
    {

        if ($this->program->program_type == "paid" && !$this->checkFeeDetail($this->program, "admission_fee")) {
            $notification = new MemberNotification;
            $notification->member_id = auth()->id();
            $notification->title =  'Unable to access ' . $this->program->program_name;
            $notification->body = "You are not authorized to join the session because of your pending dues. Please clear all the dues to access the content without distrubance or contact support for more information.";
            $notification->type = "message";
            $notification->level = "info";
            $notification->seen = false;
            $notification->save();
            session()->flash("error", 'Unable to join session, Your payment is due.');
        }

        return true;
    }
}
