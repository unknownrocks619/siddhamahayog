<?php

namespace App\Observers\Frontend\Notification;

use App\Models\MemberNotification;
use Illuminate\Support\Facades\Cache;

class MemberNotificationObserver
{
    /**
     * Handle the MemberNotification "created" event.
     *
     * @param  \App\Models\MemberNotification  $memberNotification
     * @return void
     */
    public function created(MemberNotification $memberNotification)
    {
        //
        Cache::put("event_settings", MemberNotification::where('seen', false)->get());
    }

    /**
     * Handle the MemberNotification "updated" event.
     *
     * @param  \App\Models\MemberNotification  $memberNotification
     * @return void
     */
    public function updated(MemberNotification $memberNotification)
    {
        //
        Cache::put("event_settings", MemberNotification::where('seen', false)->get());
    }

    /**
     * Handle the MemberNotification "deleted" event.
     *
     * @param  \App\Models\MemberNotification  $memberNotification
     * @return void
     */
    public function deleted(MemberNotification $memberNotification)
    {
        //
    }

    /**
     * Handle the MemberNotification "restored" event.
     *
     * @param  \App\Models\MemberNotification  $memberNotification
     * @return void
     */
    public function restored(MemberNotification $memberNotification)
    {
        //
    }

    /**
     * Handle the MemberNotification "force deleted" event.
     *
     * @param  \App\Models\MemberNotification  $memberNotification
     * @return void
     */
    public function forceDeleted(MemberNotification $memberNotification)
    {
        //
    }
}
