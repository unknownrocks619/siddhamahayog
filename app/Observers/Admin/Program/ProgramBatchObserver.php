<?php

namespace App\Observers\Admin\Program;

use App\Models\ProgramBatch;

class ProgramBatchObserver
{
    /**
     * Handle the ProgramBatch "created" event.
     *
     * @param  \App\Models\ProgramBatch  $programBatch
     * @return void
     */
    public function created(ProgramBatch $programBatch)
    {
        //

        if ($programBatch->active) {
            $currentActive = ProgramBatch::where('id', "!=", $programBatch->id)->where('program_id', request()->program->id)->where('active', true)->get();
            foreach ($currentActive as $active_batch) {
                $active_batch->active = false;
                $active_batch->saveQuietly();
            }
        }
    }

    /**
     * Handle the ProgramBatch "updated" event.
     *
     * @param  \App\Models\ProgramBatch  $programBatch
     * @return void
     */
    public function updated(ProgramBatch $programBatch)
    {
        //
    }

    /**
     * Handle the ProgramBatch "deleted" event.
     *
     * @param  \App\Models\ProgramBatch  $programBatch
     * @return void
     */
    public function deleted(ProgramBatch $programBatch)
    {
        //
    }

    /**
     * Handle the ProgramBatch "restored" event.
     *
     * @param  \App\Models\ProgramBatch  $programBatch
     * @return void
     */
    public function restored(ProgramBatch $programBatch)
    {
        //
    }

    /**
     * Handle the ProgramBatch "force deleted" event.
     *
     * @param  \App\Models\ProgramBatch  $programBatch
     * @return void
     */
    public function forceDeleted(ProgramBatch $programBatch)
    {
        //
    }
}
