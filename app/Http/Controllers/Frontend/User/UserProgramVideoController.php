<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Program\ProgramVideoLessionWatchRequest;
use App\Http\Requests\Frontend\User\Program\ProgramVideoListRequest;
use App\Http\Requests\Frontend\User\Program\VideoAllowedToWatchRequest;
use App\Http\Traits\CourseFeeCheck;
use App\Models\LessionWatchHistory;
use App\Models\Program;
use App\Models\ProgramChapterLession;
use App\Models\ProgramCourse;
use App\Models\ProgramStudent;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserProgramVideoController extends Controller
{
    //
    use CourseFeeCheck;

    public function index(ProgramVideoListRequest $request, Program $program)
    {
        $programStudent = ProgramStudent::where('program_id', $program->getKey())->where('student_id', user()->getKey())->where('active', true)->exists();

        if (!$programStudent) {
            return view('frontend.user.program.cancelled', compact('program'));
        }

        $program->load(["videoCourses" => function ($query) {
            return $query->with(["lession"]);
        }, "last_video_history"]);

        return view("frontend.user.program.videos.folder-view", compact("program"));
    }

    public function continueWatch() {}

    public function videos(ProgramVideoLessionWatchRequest $request, Program $program, ProgramCourse $course, ProgramChapterLession $lession)
    {

        if (!$request->header('X-CSRF-TOKEN')) {
            return response(['message' => "Bearer Token Missing."], 403);
        }
        $content = view("frontend.user.program.videos.modal.video", compact('program', 'course', 'lession'))->render();
        return $this->json(true, '', '', ['content' => $content, 'modalID' => 'videoModal']);
    }

    public function storeHistory(ProgramVideoLessionWatchRequest $request, Program $program, ProgramCourse $course, ProgramChapterLession $lession)
    {
        $history = new LessionWatchHistory;
        $history->student_id = auth()->id();
        $history->program_id = $program->id;
        $history->program_course_id = $course->id;
        $history->program_chapter_lession_id = $lession->id;

        try {
            $history->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(["success" => false, 'message' => "Watch history error"], 500);
        }
        return response(["success" => true, 'message' => "done"], 200);
    }

    public function showHistory(ProgramVideoLessionWatchRequest $request, Program $program)
    {
        $watchHistory = LessionWatchHistory::where('program_id', $program->id)->where('student_id', auth()->id())->latest()->first();

        if (!$watchHistory) {
            return view("frontend.user.program.videos.modal.no-history");
        }

        return view('frontend.user.program.videos.modal.history', compact("watchHistory"));
    }

    public function allowedToWatch(VideoAllowedToWatchRequest $request, Program $program, ProgramChapterLession $lession)
    {
        if (!$request->header('X-CSRF-TOKEN')) {
            return response(['message' => "Bearer Token Missing."], 403);
        }

        if (!$this->checkFeeDetail($program, "admission_fee")) {
            return view('frontend.user.program.videos.partials.video-lock', compact('lession', 'lession'));
        }

        // get video
        if ($lession->course->lock) {
            // entire thing lock,
            return view('frontend.user.program.videos.partials.video-lock', compact('lession', 'lession'));
        }

        if ($lession->video_lock && !$lession->lock_after) {
            // lock video watch.
        }

        if ($lession->lock_after) {
            $parseDate = Carbon::parse($lession->created_at);

            if ($lession->lession_date) {
                $parseDate = Carbon::parse($lession->lession_date);
            }

            $parseDate->addDays($lession->lock_after);
            $now = Carbon::now();

            if ($now->greaterThan($parseDate)) {
                // lock video watch
                return view('frontend.user.program.videos.partials.video-lock', compact('lession', 'lession'));
            }
        }

        return;
    }
}
