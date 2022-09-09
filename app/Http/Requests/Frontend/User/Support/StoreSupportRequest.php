<?php

namespace App\Http\Requests\Frontend\User\Support;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->check()) ? true : false;
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
            "title" => "required|string",
            "category" => "required|in:finance,admission,technical_support,other",
            "priority" => "required|in:high,low,medium",
            "message" => "required|min:5",
            "media" => "nullable|mimes:png,jpg,gif"
        ];
    }


    public function messages()
    {
        return [
            "title.required" => "Please provide subject.",
            "title.string" => "Invalid character in subject.",
            "category.required" => "Please Selecte Category.",
            "category.in" => "Invalid Category.",
            "priority.required" => "Please Selected Ticket Priority.",
            "priority.in" => "Invalid priority.",
            "message.required" => "Please provide your message.",
            "message.min" => "Please provide valid message.",
            "media.mimes" => "Only JPG and PNG are supported."
        ];
    }
}
