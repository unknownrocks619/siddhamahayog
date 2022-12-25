<?php

namespace App\Http\Requests\Frontend\Event;

use App\Http\Traits\CourseFeeCheck;
use App\Models\MemberNotification;
use App\Models\Scholarship;
use App\Models\UnpaidAccess;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class LiveEventRequest extends FormRequest
{
    use CourseFeeCheck;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->check() && $this->isPaid()) ?? false;
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

    public function isPaid()
    {

        if ($this->program->program_type  != 'paid') {
            return true;
        }

        $scholarship = Scholarship::where('program_id', $this->program->getKey())
            ->where('student_id', auth()->id())
            ->first();

        if ($scholarship) {
            return true;
        }

        if ($this->checkFeeDetail($this->program, 'admission_fee')) {
            return true;
        }

        if (user()->email == 'unknownrocks619@outlook.com') {
            dd(site_settings('unpaid_access'));
        }
        
        if (UnpaidAccess::totalAccess(user(), $this->program) <= site_settings('unpaid_access')) {

            $unpaidAccess = UnpaidAccess::where('program_id', $this->program->getKey())->where('member_id', user()->getKey())->first();

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
                $storeAccess->save();
            }

            return true;
        }

        return false;
    }
}
