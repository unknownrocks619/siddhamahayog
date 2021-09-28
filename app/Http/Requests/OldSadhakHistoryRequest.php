<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OldSadhakHistoryRequest extends FormRequest
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
            "daily_practice" => "required|in:yes,no",
            'daily_time' => 'required_if:daily_practice,yes',
            'engaged_other' => ["required",Rule::in(["yes","no"])],
            'start_date' => ["array"],
            'end_date' => ['array']
        ];
    }

    public function messages(){
        return [
            'start_date.array' => "Invalid Start Date Format",
            'end_date.array' => "Invalid End Date" 
        ];
    }
}
