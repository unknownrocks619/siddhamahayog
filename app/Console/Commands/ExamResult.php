<?php

namespace App\Console\Commands;

use App\Jobs\CreateResultJob;
use App\Models\Member;
use App\Models\ProgramExam;
use Illuminate\Console\Command;

class ExamResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:exam:result {user} {exam}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Exam result.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CreateResultJob::dispatchSync(
                                Member::find($this->argument('user')),
                                ProgramExam::find($this->argument('exam'))
                            );
        return 0;
    }
}
