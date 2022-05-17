<?php

namespace App\Http\Requests\Zoom\API;

use Illuminate\Foundation\Http\FormRequest;

class ZoomAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            "meeting_name" => "required",
            "meeting_type" => "required",
            "meeting_lock" => "required|in:yes,no",
            "meeting_interval" => "required_if:meeting_lock,yes",
            "timezone" => "required",
            "cron_job" => "sometimes|required|in:yes,no",
            "country_lock" => "required|in:yes,no",
            "scheduled_date" => "required_if:meeting_type,scheduled",
            "scheduled_time" => "required_if:meeting_type,scheduled",
            "reoccuring" => "required_if:meeting_type,reoccuring",
            "reoccuring_meeting_timing" => "required_if:meeting_type,reoccuring"
        ];
    }

    public function message() {
        return [
            "meeting_name.required" => "Please provide valid meeting name.",
            "meeting_name.alpha_dash" => "Meeting Name should contains only Alphabet charater",
            "meeting_type.required" => "Please Select meeting type.",
        ];
    }
}
