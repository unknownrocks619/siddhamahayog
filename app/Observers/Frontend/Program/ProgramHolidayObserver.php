<?php

namespace App\Observers\Frontend\Program;

use App\Models\Member;
use App\Models\ProgramHoliday;
use App\Notifications\Frontend\User\HolidayRequestNotification;
use Illuminate\Support\Facades\Notification;

class ProgramHolidayObserver
{
    /**
     * Handle the ProgramHoliday "created" event.
     *
     * @param  \App\Models\ProgramHoliday  $programHoliday
     * @return void
     */
    public function created(ProgramHoliday $programHoliday)
    {
        //
        $members = Member::whereIn("role_id", [1, 8])->get();

        foreach ($members as $member) {
            // send notification 
            Notification::send($member, new HolidayRequestNotification($programHoliday));
        }
    }

    /**
     * Handle the ProgramHoliday "updated" event.
     *
     * @param  \App\Models\ProgramHoliday  $programHoliday
     * @return void
     */
    public function updated(ProgramHoliday $programHoliday)
    {
        //
    }

    /**
     * Handle the ProgramHoliday "deleted" event.
     *
     * @param  \App\Models\ProgramHoliday  $programHoliday
     * @return void
     */
    public function deleted(ProgramHoliday $programHoliday)
    {
        //
    }

    /**
     * Handle the ProgramHoliday "restored" event.
     *
     * @param  \App\Models\ProgramHoliday  $programHoliday
     * @return void
     */
    public function restored(ProgramHoliday $programHoliday)
    {
        //
    }

    /**
     * Handle the ProgramHoliday "force deleted" event.
     *
     * @param  \App\Models\ProgramHoliday  $programHoliday
     * @return void
     */
    public function forceDeleted(ProgramHoliday $programHoliday)
    {
        //
    }
}
