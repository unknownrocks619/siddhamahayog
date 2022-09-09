<?php

namespace App\Observers\Frontend\Support;

use App\Models\SupportTicket;

class SupportEventObserver
{
    /**
     * Handle the SupportTicket "created" event.
     *
     * @param  \App\Models\SupportTicket  $supportTicket
     * @return void
     */
    public function created(SupportTicket $supportTicket)
    {
        //
        if ($supportTicket->parent_id) {
            // get parent detail.
            $main_thread = SupportTicket::find($supportTicket->parent_id);
            // also count total parent.
            $total_post = SupportTicket::where('parent_id', $main_thread->id)->count();
            $main_thread->total_count = $total_post;
            $main_thread->saveQuietly();
        }
    }

    /**
     * Handle the SupportTicket "updated" event.
     *
     * @param  \App\Models\SupportTicket  $supportTicket
     * @return void
     */
    public function updated(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the SupportTicket "deleted" event.
     *
     * @param  \App\Models\SupportTicket  $supportTicket
     * @return void
     */
    public function deleted(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the SupportTicket "restored" event.
     *
     * @param  \App\Models\SupportTicket  $supportTicket
     * @return void
     */
    public function restored(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Handle the SupportTicket "force deleted" event.
     *
     * @param  \App\Models\SupportTicket  $supportTicket
     * @return void
     */
    public function forceDeleted(SupportTicket $supportTicket)
    {
        //
    }
}
