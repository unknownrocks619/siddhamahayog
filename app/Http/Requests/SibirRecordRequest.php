<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SibirRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->check() && isAdmin() ) {
            return true;
        }
        return false;
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
            "active" => "sometimes|in:on",
            'application_title' => "required|unique:sibir_records,sibir_title"
        ];
    }
}
