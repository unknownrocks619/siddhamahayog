<?php

namespace App\Http\Requests\Frontend\Exam;

use App\Models\UnpaidAccess;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ExamAttendValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && $this->checkFeeDetail($this->program, 'admission');
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

    /**
     * Summary of validateUser
     * @return bool
     */
    public function validateUser(): bool
    {
        if (UnpaidAccess::totalAccess(user(), $this->program) <= site_settings('unpaid_access')) {

            $unpaidAccess = UnpaidAccess::where('program_id', $this->program->getKey())
                ->where('member_id', user()->getKey())
                ->where('access_type', 'exam')
                ->first();

            if ($unpaidAccess) {

                $currentDate = Carbon::parse($unpaidAccess->updated_at);

                if (!$currentDate->isToday()) {

                    $unpaidAccess->total_joined++;
                    $unpaidAccess->save();
                }
            } else {
                $storeAccess = new UnpaidAccess();
                $storeAccess->member_id = user()->getKey();
                $storeAccess->program_id = $this->program->getKey();
                $storeAccess->total_joined = 1;
                $storeAccess->relation_table = '\\App\Models\ProgramExam';
                $storeAccess->relation_id = $this->exam->getKey();
                $storeAccess->save();
            }
            return true;
        }

        return false;
    }
}
