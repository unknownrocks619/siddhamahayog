<?php

namespace App\Observers\Dharmasala;

use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\DharmasalaBookingLogs;

class DharmasalaBookingObserver
{
    /**
     * Handle the DharmasalaBooking "created" event.
     *
     * @param  App\Models\Dharmasala\DharmasalaBooking  $dharmasalaBooking
     * @return void
     */
    public function created(DharmasalaBooking $dharmasalaBooking)
    {
        //
    }

    /**
     * Handle the DharmasalaBooking "updated" event.
     *
     * @param  App\Models\Dharmasala\DharmasalaBooking $dharmasalaBooking
     * @return void
     */
    public function updated(DharmasalaBooking $dharmasalaBooking)
    {
        $updateAll = true;
        // check if update was in status
        if ( $dharmasalaBooking->getOriginal('status') !== $dharmasalaBooking->getAttribute('status')) {

            $dharmasalaBookingLogs = new DharmasalaBookingLogs;
            $dharmasalaBookingLogs->fill([
                'booking_id'    => $dharmasalaBooking->getKey(),
                'original_content'  => $dharmasalaBooking->getOriginal(),
                'changed_content'   => $dharmasalaBooking->getAttributes(),
                'original_type_value'    => $dharmasalaBooking->getOriginal('status'),
                'change_type_value' => $dharmasalaBooking->getAttribute('status'),
                'type'  => 'booking_status',
                'updated_by'    => auth()->id()
            ]);

            $dharmasalaBooking->saveQuietly();

            $updateAll = false;
        }

        if ($dharmasalaBooking->getOriginal('check_in') != $dharmasalaBooking->getAttribute('check_in') ) {

            $dharmasalaBookingLogs = new DharmasalaBookingLogs;

            $dharmasalaBookingLogs->fill([
                'booking_id'    => $dharmasalaBooking->getKey(),
                'original_content'  => $dharmasalaBooking->getOriginal(),
                'changed_content'   => $dharmasalaBooking->getAttributes(),
                'original_type_value'    => $dharmasalaBooking->getOriginal('check_in'),
                'change_type_value' => $dharmasalaBooking->getAttribute('check_in'),
                'type'  => 'check_in',
                'updated_by'    => auth()->id()
            ]);

            $dharmasalaBooking->saveQuietly();

            $updateAll = false;

        }

        if ($dharmasalaBooking->getOriginal('check_out') != $dharmasalaBooking->getAttribute('check_out') ) {

            $dharmasalaBookingLogs = new DharmasalaBookingLogs;

            $dharmasalaBookingLogs->fill([
                'booking_id'    => $dharmasalaBooking->getKey(),
                'original_content'  => $dharmasalaBooking->getOriginal(),
                'changed_content'   => $dharmasalaBooking->getAttributes(),
                'original_type_value'    => $dharmasalaBooking->getOriginal('check_out'),
                'change_type_value' => $dharmasalaBooking->getAttribute('check_out'),
                'type'  => 'check_out',
                'updated_by'    => auth()->id()
            ]);

            $dharmasalaBooking->saveQuietly();

            $updateAll = false;
        }


        if ( $updateAll === true) {

            $dharmasalaBookingLogs = new DharmasalaBookingLogs;

            $dharmasalaBookingLogs->fill([
                'booking_id'    => $dharmasalaBooking->getKey(),
                'original_content'  => $dharmasalaBooking->getOriginal(),
                'changed_content'   => $dharmasalaBooking->getAttributes(),
                'original_type_value'    => $dharmasalaBooking->getOriginal(),
                'change_type_value' => $dharmasalaBooking->getAttributes(),
                'type'  => 'booking_general',
                'updated_by'    => auth()->id()
            ]);

            $dharmasalaBooking->saveQuietly();
        }
    }

    /**
     * Handle the DharmasalaBooking "deleted" event.
     *
     * @param  App\Models\Dharmasala\DharmasalaBooking $dharmasalaBooking
     * @return void
     */
    public function deleted(DharmasalaBooking $dharmasalaBooking)
    {
        //
    }

    /**
     * Handle the DharmasalaBooking "restored" event.
     *
     * @param  App\Models\Dharmasala\DharmasalaBooking  $dharmasalaBooking
     * @return void
     */
    public function restored(DharmasalaBooking $dharmasalaBooking)
    {
        //
    }

    /**
     * Handle the DharmasalaBooking "force deleted" event.
     *
     * @param  App\Models\Dharmasala\DharmasalaBooking  $dharmasalaBooking
     * @return void
     */
    public function forceDeleted(DharmasalaBooking $dharmasalaBooking)
    {
        //
    }
}
