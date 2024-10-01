<?php

namespace App\Console\Commands;

use App\Classes\Import\EventRegistration;
use Illuminate\Console\Command;

class UserRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:event:registration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import All from event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        (new EventRegistration('siddhamahayog.xlsx'))->processFile();
    }
}
