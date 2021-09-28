<?php

namespace App\Observers;

use App\Models\EventVideoClassController;

class EventVideoClassObserver
{

    public function view(){
    }

    /**
     * Handle the EventVideoClassController "created" event.
     *
     * @param  \App\Models\EventVideoClassController  $eventVideoClassController
     * @return void
     */
    public function created(EventVideoClassController $eventVideoClassController)
    {
        //
    }

    /**
     * Handle the EventVideoClassController "updated" event.
     *
     * @param  \App\Models\EventVideoClassController  $eventVideoClassController
     * @return void
     */
    public function updated(EventVideoClassController $eventVideoClassController)
    {
        //
    }

    /**
     * Handle the EventVideoClassController "deleted" event.
     *
     * @param  \App\Models\EventVideoClassController  $eventVideoClassController
     * @return void
     */
    public function deleted(EventVideoClassController $eventVideoClassController)
    {
        //
    }

    /**
     * Handle the EventVideoClassController "restored" event.
     *
     * @param  \App\Models\EventVideoClassController  $eventVideoClassController
     * @return void
     */
    public function restored(EventVideoClassController $eventVideoClassController)
    {
        //
    }

    /**
     * Handle the EventVideoClassController "force deleted" event.
     *
     * @param  \App\Models\EventVideoClassController  $eventVideoClassController
     * @return void
     */
    public function forceDeleted(EventVideoClassController $eventVideoClassController)
    {
        //
    }
}
