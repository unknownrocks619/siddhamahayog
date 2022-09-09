<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() ? true : false;
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
            "first_name" => "required|string",
            "middle_name" => "nullable|string",
            "last_name" => "required|string",
            "gender" => "required|in:male,female",
            "phone_number" => "required|size:10",
            "country" => "required",
            "address" => "required",
            "state" => "required"
        ];
    }
}
