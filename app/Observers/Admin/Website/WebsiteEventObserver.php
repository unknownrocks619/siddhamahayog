<?php

namespace App\Observers\Admin\Website;

use App\Models\WebsiteEvents;
use Illuminate\Support\Facades\Cache;

class WebsiteEventObserver
{
    /**
     * Handle the WebsiteEvents "created" event.
     *
     * @param  \App\Models\WebsiteEvents  $websiteEvents
     * @return void
     */
    public function created(WebsiteEvents $websiteEvents)
    {
        //
        Cache::put("event_settings",WebsiteEvents::get());
    }

    /**
     * Handle the WebsiteEvents "updated" event.
     *
     * @param  \App\Models\WebsiteEvents  $websiteEvents
     * @return void
     */
    public function updated(WebsiteEvents $websiteEvents)
    {
        //
        Cache::put("event_settings",WebsiteEvents::get());
    }

    /**
     * Handle the WebsiteEvents "deleted" event.
     *
     * @param  \App\Models\WebsiteEvents  $websiteEvents
     * @return void
     */
    public function deleted(WebsiteEvents $websiteEvents)
    {
        //
        Cache::put("event_settings",WebsiteEvents::get());
    }

    /**
     * Handle the WebsiteEvents "restored" event.
     *
     * @param  \App\Models\WebsiteEvents  $websiteEvents
     * @return void
     */
    public function restored(WebsiteEvents $websiteEvents)
    {
        //
        Cache::put("event_settings",WebsiteEvents::get());
    }

    /**
     * Handle the WebsiteEvents "force deleted" event.
     *
     * @param  \App\Models\WebsiteEvents  $websiteEvents
     * @return void
     */
    public function forceDeleted(WebsiteEvents $websiteEvents)
    {
        //
        Cache::put("event_settings",WebsiteEvents::get());
    }
}
