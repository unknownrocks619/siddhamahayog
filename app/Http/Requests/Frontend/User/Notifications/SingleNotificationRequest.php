<?php

namespace App\Http\Requests\Frontend\User\Notifications;

use Illuminate\Foundation\Http\FormRequest;

class SingleNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->check()) return true;

        if ($this->notification->member_id != auth()->id()) return false;

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
        ];
    }
}
