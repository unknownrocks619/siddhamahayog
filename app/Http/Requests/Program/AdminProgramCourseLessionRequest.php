<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class AdminProgramCourseLessionRequest extends FormRequest
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
            "lession_name" => "required",
            // "total_video_duration" => "required|date_format:H:m:s",
            // "video_publish_date" => "required|date_format:Y-m-d",
            "vimeo_video_url" => "required|url"
        ];
    }
}
