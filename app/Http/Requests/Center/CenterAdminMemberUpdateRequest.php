<?php

namespace App\Http\Requests\Center;

use Illuminate\Foundation\Http\FormRequest;

class CenterAdminMemberUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->member->role_id == 7) {
            return true;
        }
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
            'first_name' => "required|string",
            "middle_name" => "nullable|string",
            "last_name" => "required|string",
            "country" => "required",
            "state" => "required",
            "address" => "required"
        ];
    }
}
