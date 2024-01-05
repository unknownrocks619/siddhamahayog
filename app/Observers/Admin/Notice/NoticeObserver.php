<?php

namespace App\Observers\Admin\Notice;

use App\Models\Notices;
use Illuminate\Support\Facades\Cache;

class NoticeObserver
{
    /**
     * Handle the Notice "created" event.
     *
     * @param  \App\Models\Notice  $notice
     * @return void
     */
    public function created(Notices $notice)
    {
        //
        Cache::add("notices", Notices::latest()->get());
    }

    /**
     * Handle the Notice "updated" event.
     *
     * @param  \App\Models\Notices  $notice
     * @return void
     */
    public function updated(Notices $notice)
    {
        //
        Cache::add("notices", Notices::latest()->get());
    }

    /**
     * Handle the Notice "deleted" event.
     *
     * @param  \App\Models\Notices  $notice
     * @return void
     */
    public function deleted(Notices $notice)
    {
        //
        Cache::delete('notices');
        Cache::add("notices", Notices::latest()->get());
    }

    /**
     * Handle the Notice "restored" event.
     *
     * @param  \App\Models\Notices  $notice
     * @return void
     */
    public function restored(Notices $notice)
    {
        //
    }

    /**
     * Handle the Notice "force deleted" event.
     *
     * @param  \App\Models\Notices  $notice
     * @return void
     */
    public function forceDeleted(Notices $notice)
    {
        //
    }
}
