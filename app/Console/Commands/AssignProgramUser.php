<?php

namespace App\Console\Commands;

use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Console\Command;

class AssignProgramUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:user:program {ProgramID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign All user to given program';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit',-1);

        // for the moment just assign pre user to correct.
        $program = Program::with(['active_sections','active_batch'])
            ->where('id',$this->argument('ProgramID'))->firstOrFail();

        if ( ! $program || ! $program->active_sections || ! $program->active_batch) {

            die('Selected Program does not have any active section or batch assigned.');
        }

        $paidProgram = Program::where('id',2)->with('students')->first();

        $studentsList = $paidProgram->students()->where('active',true)->get();
        $newProgramList = [];

        foreach ($studentsList as $student) {

            $newProgramList[] = [
                'program_id' => $program->getKey(),
                'program_section_id' => $program->active_sections->getKey(),
                'student_id' => $student->getKey(),
                'batch_id'  => $program->active_batch->getKey(),
                'active'    => true
            ];
        }

        try {
            ProgramStudent::insert($newProgramList);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
