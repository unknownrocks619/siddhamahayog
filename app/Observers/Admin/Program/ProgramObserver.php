<?php

namespace App\Observers\Admin\Program;

use App\Models\Program;

class ProgramObserver
{
    /**
     * Handle the Program "created" event.
     *
     * @param  \App\Models\Program  $program
     * @return void
     */
    public function created(Program $program)
    {
        //
    }

    /**
     * Handle the Program "updated" event.
     *
     * @param  \App\Models\Program  $program
     * @return void
     */
    public function updated(Program $program)
    {
        //
    }

    /**
     * Handle the Program "deleted" event.
     *
     * @param  \App\Models\Program  $program
     * @return void
     */
    public function deleted(Program $program)
    {
        //
        
    }

    /**
     * Handle the Program "restored" event.
     *
     * @param  \App\Models\Program  $program
     * @return void
     */
    public function restored(Program $program)
    {
        //
    }

    /**
     * Handle the Program "force deleted" event.
     *
     * @param  \App\Models\Program  $program
     * @return void
     */
    public function forceDeleted(Program $program)
    {
        //
    }
}
