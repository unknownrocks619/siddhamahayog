<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\UserTrainingCourse;
use Illuminate\Http\Request;

class UserTeacherController extends Controller
{
    //
    public function teacherSession(Request $request, ?Member $member = null, $returnType = 'json')
    {
        if (! user()->role()->isTeacher()) {
            abort(404);
        }

        $request->validate([
            'group_name' => 'required',
            'status' => 'required',
            'event_id'  => 'required',
            'training_location' => 'required',
            'training_type' => 'required'
        ]);

        $trainingSession = new UserTrainingCourse();
        $trainingSession->fill([
            'course_group_name' => $request->post('group_name'),
            'event_id'  => $request->post('event_id'),
            'course_status' => $request->post('status'),
            'training_location' => $request->post('training_location'),
            'id_user'   => $member?->getKey() ?? auth('web')->id()
        ]);

        if (! $trainingSession->save()) {
            return $this->json(false, 'Failed to create new Training Session');
        }

        if ($returnType == 'json') {
            return $this->json(true, 'New Training Session Created.', 'reload');
        }

        return $trainingSession;
    }
}
