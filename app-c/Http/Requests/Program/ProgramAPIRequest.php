<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class ProgramAPIRequest extends FormRequest
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
            'program_name' => "required",
            "program_type" => "required",
            "promote" => "required|",
            "monthly_fee" => "required_if:program_type,paid",
            "admission_fee" => "required_if:program_type,paid",
            "overdue_allowed" => "required_if:program_type,paid"
        ];
    }
}
