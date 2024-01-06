<?php

namespace App\Http\Requests\Frontend\Event;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class LiveEventJoinAsAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return (auth()->check() && (auth()->user()->role_id == Role::SUPER_ADMIN || auth()->user()->role_id == Role::ACTING_ADMIN || auth()->user()->role_id == Role::ADMIN) );
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
}
