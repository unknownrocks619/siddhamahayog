<?php

namespace App\Http\Controllers\API\V1\Programs;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Events\EventController;
use App\Http\Requests\Frontend\Event\LiveEventRequest;
use App\Models\Live;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    //

    public function userProgram()
    {


        $user  = user()->getKey();
        $studentPrograms = ProgramStudent::select(['program_id'])->where('student_id', $user)->get()->pluck('program_id')->toArray();
        $programs = Program::select(['id', 'program_name'])->whereIn('id', $studentPrograms)
            ->with('videoCourses', 'courses', 'videoCourses.lession')
            ->get();
        $returnPrograms = [];

        foreach ($programs as $program) {
            $innerArray = [
                'name'  => $program->program_name,
                'id'    => (int) $program->getKey(),
                'videos'    => [],
                'resources' => []
            ];

            if ($program->videoCourses->count()) {
                $videCourses = [];
                foreach ($program->videoCourses as $videoCourse) {
                    $courseInnerArray = [
                        'id'    => $videoCourse->getKey(),
                        'course_name'   => $videoCourse->course_name,
                        'lesions'  => []
                    ];

                    if ($videoCourse->lession->count()) {
                        $lesions = [];

                        foreach ($videoCourse->lession as $lesion) {
                            $lesionInnerArray = [
                                'lesion_name' => $lesion->lession_name,
                                'id'    => $lesion->getKey(),
                                'total_duration'    => $lesion->total_duration,
                                'online_source' => $lesion->online_medium,
                                'video_lock' => $lesion->video_lock,
                                'description' => $lesion->video_description,
                                'status'    => $lesion->status,
                                'link'  => str($lesion->video_link)->afterLast('/')->value()
                            ];

                            $lesions[] = $lesionInnerArray;
                        }

                        $courseInnerArray['lesions'] = $lesions;
                    }
                    $videCourses[] = $courseInnerArray;
                }

                $innerArray['videos'] = $videCourses;
            }
            $returnPrograms[] = $innerArray;
        }

        return response()->json(
            $returnPrograms,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }


    public function livePrograms()
    {
        $user = user();

        // get current user enrolled program.
        $userProgram = $user->member_detail;

        $livePrograms = Live::whereIn('program_id', $userProgram->pluck('program_id')->toArray())
            ->where('live', 1)
            ->whereIn('section_id', $userProgram->pluck('program_section_id')->toArray())
            ->with(['program', 'programSection'])
            ->get();

        $response = [];

        foreach ($livePrograms as $liveProgram) {

            $response[] = [
                'liveID'    => $liveProgram->getKey(),
                'meetingId' => (int) $liveProgram->meeting_id,
                'programName'   =>  $liveProgram->program?->program_name ?? 'test',
                'sectionId' => $liveProgram->section_id,
                'meetingStarted' => date('Y-m-d H:i:s', strtotime($liveProgram->created_at)),
                'isLive'    => true,
                'programId' => $liveProgram->program_id
            ];
        }

        return $response;
    }

    public function joinSession(Request $request)
    {
        // $request->validate([
        //     'id'    => 'required|numeric',
        //     'meetingId' => 'required|numeric'
        // ]);
        // $this->authUser();
        $liveID = $request->post('id') ?? 1396;
        $live = Live::where('id', $liveID)->firstOrFail();
        $program = $live->program;

        $programSection = $live->programSection;
        $newLiveRequest = new LiveEventRequest([], []);
        $liveEventResponse = (new EventController())->liveEventAjax($newLiveRequest, $program, $live, $programSection);

        if (! $liveEventResponse) {
            return response('Access Denied', 403);
        }
        /** @var  RedirectResponse $liveEventResponse */
        return response([
            'access'    => true,
            'url'   => $liveEventResponse->getTargetUrl(),
        ]);
    }

    public function authUser()
    {
        $user = Member::first();
        Auth::loginUsingId($user->getKey());
    }
}
