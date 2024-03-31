<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\Programs\AdminProgramGroupController;
use App\Models\ProgramGroupPeople;
use Illuminate\Console\Command;

class generateID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Generate ID card';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $peoples = ProgramGroupPeople::where('is_card_generated',false)
                                        ->where('is_parent',true)
                                        ->with(['group','families','program'])
                                        ->get();
        foreach ( $peoples as $people ) {
            (new AdminProgramGroupController())->generateIDCard($people->program,$people->group,$people);
        }
    }
}
