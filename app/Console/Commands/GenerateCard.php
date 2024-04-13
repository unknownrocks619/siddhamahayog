<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\Programs\AdminProgramGroupController;
use App\Models\Program;
use App\Models\ProgramGroupPeople;
use Illuminate\Console\Command;

class generateCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:card {programID} {groupID?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $generateCardQuery = ProgramGroupPeople::with(['program','programGroup'])->where('is_card_generated',false);
        $programID = $this->argument('programID');
        if ( $this->argument('groupID') ) {
            $generateCardQuery->where('group_id',(int) $this->argument('groupID'));
        }
        if ($programID ) {
            $generateCardQuery->where('program_id', (int)  $programID);
        }

        $generateCard = $generateCardQuery->get();

        foreach ($generateCard as $people) {
            (new AdminProgramGroupController())->generateIDCard($people->program,$people->programGroup,$people);
        }
    }
}
