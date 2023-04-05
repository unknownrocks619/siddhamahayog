<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\SMS;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;

class CodeTestZoneController extends Controller
{
    //
    public function getAllRegisteredSadhak()
    {
        $programStudent  = ProgramStudent::where('program_id', 2)
            ->where('active', true)
            ->with(['student' => function ($subQuery) {
                return $subQuery->where('country', 153);
            }])
            ->get();

        $sentList = [];
        $phoneList = [];
        $message = 'सीताराम! भोलि हनुमान जयन्तीको दिनदेखि वेदान्त कक्षा विहान ४:२५ बाट सुरु हुने जानकारी गराउँदछौँ। कृपया भोलि यहाँहरु उपस्थित हुनुहोला।';
        foreach ($programStudent as $program_student) {
            $student = $program_student->student;
            if (!$student || $student->getKey() <= 1857) {
                continue;
            }

            if (in_array($student->getKey(), $sentList) || in_array($student->phone_number, $phoneList) ||  !$student->phone_number) {
                continue;
            }

            $regex = '/^(\+?977-?)?(\d{10}|\d{3}-\d{7}|\d{7})$/';
            if (!preg_match($regex, $student->phone_number)) {
                continue;
            }

            echo "Processing : " . $student->full_name . ' - ' . $student->getKey() . '<br />';
            echo 'Processing : ' . $student->phone_number . ' <hr />';

            $phoneList[] = $student->phone_number;
            $sentList[] = $student->getKey();
            // SMS::sparrowMessage(['to' => $student->phone_number, 'text' => $message]);
        }
        // dd($sentList);
    }
}
