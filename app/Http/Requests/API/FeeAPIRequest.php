<?php

namespace App\Http\Requests\API;

use App\Models\CenterMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FeeAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $studentID = $this->fee_detail?->student_id ?? $this->transaction->student_id;

        if (adminUser()?->role()->isSuperAdmin()) {
            return true;
        }

        /** Check if record was inserted from same center. */
        if (adminUser()?->role()->iscenterAdmin() || adminUser()?->role()->isCenter() ) {
            $centerMember = CenterMember::where('member_id',$studentID)->where('center_id',adminUser()->center_id)->exists();
            return $centerMember;
        }

        if ( auth()->check() && auth()->id() === $studentID) {
            return true;
        }

        return false;
//        return (auth()->id() == ($this->fee_detail?->student_id ?? $this->transaction->student_id) || auth()->user()->role_id == 1) ? true : false;
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
//            "update_type" => "required|in:status,detail"
        ];
    }
}
