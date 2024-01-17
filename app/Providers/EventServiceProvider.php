<?php

namespace App\Providers;

use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Notices;
use App\Models\ProgramBatch as ProgramBatch;
use App\Models\ProgramHoliday;
use App\Models\SupportTicket;
use App\Models\WebsiteEvents;
use App\Observers\Admin\Notice\NoticeObserver;
use App\Observers\Admin\Program\ProgramBatchObserver;
use App\Observers\Admin\Website\WebsiteEventObserver;
use App\Observers\Dharmasala\DharmasalaBookingObserver;
use App\Observers\Frontend\Program\ProgramHolidayObserver;
use App\Observers\Frontend\Support\SupportEventObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
      DharmasalaBooking::class => [
          DharmasalaBookingObserver::class
      ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        WebsiteEvents::observe(WebsiteEventObserver::class);
        ProgramBatch::observe(ProgramBatchObserver::class);
        SupportTicket::observe(SupportEventObserver::class);
        ProgramHoliday::observe(ProgramHolidayObserver::class);
        Notices::observe(NoticeObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
