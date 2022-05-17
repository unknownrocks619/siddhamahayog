<?php

namespace App\Http\Requests\Website\Admin;

use Illuminate\Foundation\Http\FormRequest;

use function PHPSTORM_META\map;

class MenuControllerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {        return (auth()->check() && auth()->user()->role_id == 1) ? true : false;

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
            "menu_name" => "required",
            "menu_type" => "required",
            "active_status" => "required|boolean",
            "display" => "required",
            "menu_position" => "required"
        ];
    }
}
