<?php

namespace App\Listeners\Admin\Program;

use App\Models\ProgramSection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProgramEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        $section = new ProgramSection;
        $section->program_id = $event->program->id;
        $section->section_name = "SECTION-A";
        $section->slug = "section-a";
        $section->default = true;
        $section->saveQuietly();
    }
}
