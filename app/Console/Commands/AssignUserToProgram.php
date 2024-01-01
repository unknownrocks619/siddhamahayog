<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use Illuminate\Console\Command;

class AssignUserToProgram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:program:user {ProgramID}';

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
        ini_set('memory_limit',-1);

        // for the moment just assign pre user to correct.
        $program = Program::with(['active_sections','active_batch'])
            ->where('id',$this->argument('ProgramID'))->firstOrFail();

        $members  = Member::whereIn('email',$this->userEmailList())->get();

        foreach ($members as $member) {

            // exists.
            $exists = ProgramStudent::where('program_id',$program->getKey())
                                        ->where('student_id',$member->getKey())
                                        ->exists();

            if ($exists) continue;

            $programStudent = new ProgramStudent();
            $programStudent->fill([
                'program_id' => $program->getKey(),
                'student_id'    => $member->getKey(),
                'program_section_id' => $program->active_sections->getKey(),
                'batch_id'  => $program->active_batch->getKey(),
                'active'    => true,
            ]);
            $programStudent->save();
        }

        echo 'Done !';
        return Command::SUCCESS;
    }

    public function userEmailList() {
        return [
            'neupane214@gmail.com',
            'tikaramadhikari01@gmail.com',
            'kalpanapaudel36@gmail.com',
            'narayanprasadpaudel977@gmail.com',
            'ramakhanal40@gmail.com',
            'reshamgurung030@gmail.com',
            'janakbandhu.aryal@gmail.com',
            'thapasukmaya145@gmail.com',
            'koiralaishori6@gmail.com',
            'bishnukafle95589@gmail.com',
            'gangaduwadi16@gmail.com',
            'ramkoirala684@gmail.com',
            'sapkotakrishna350@gmail.com',
            'mayadevilamsal2025@gmail.com',
            'baburampoudel@siddhamahayog.org',
            'durgagauli8681@gmail.com',
            'adhikaritilak69@gmail.com',
            'bijayaramdasi51@gmail.com',
            'devdutlalit77@gmail.com',
            'harifrmdlkh@gmail.com',
            'jamnagauli2018@gmail.com',
            'smaniram04@gmail.com',
            'nabin.sajilo@gmail.com',
            'mostlybieber26@gmail.com',
            'laxmi23@gmail.com',
            'chalisepurna@gmail.com',
            'ppgauli@gmail.com',
            'binitadangi26@gmail.com',
            'mahanandaacharya03@gmail.com',
            'sitals852@gmail.com',
            'khagisarathani@gmail.com',
            'panditbp@gmail.com',
            'nanedh57@gmail.com',
            'shivapdnepal1@gmail.com',
            'poudeljikomail@gmail.com',
            'prajajapati.shyam@gmail.com',
            'shreedhar60sp@gmail.com',
            'pandeyykamala88@gmai.com',
            'ramkumarsingh.lew@gmail.com',
            'ausstudiesnepal@gmail.com',
            'adhyatma.bigyan@gmail.com',
            'mahendragurung75@hotmail.com',
            'binu025@gmail.com',
            'navoditapokharel@gmail.com',
            'acharyawaling@gmail.com',
            'shyamkumarsubbha@siddhamahayog.org',
            'gopalthapa@siddhamahayog.org',
            'sumitraghimire@siddhamahayog.org',
            'laxmibhattarai@siddhamahayog.org',
            'debumaya@siddhamahayog.org',
            'saradakhadka@siddhamahayog.org',
            'dilugajmer@siddhamahayog.org',
            'uddhabghimire@siddhamahayog.org',
            'kaushilaraut@siddhamahayog.org',
            'chunushrestha@siddhamahayog.org',
            'tulashighimire@siddhamahayog.org',
            'binodprasad@siddhamahayog.org',
            'santoshithapa@siddhamahayog.org',
            'ashokkarki@siddhamahayog.org',
            'prabhaa@sidddhamahayog.org',
            'laxmighimire@siddhamahayog.org',
            'bishnusharma21659@gmail.com',
            'shresthashanti835@gmail.com',
            'shivnkp77@gmail.com',
            'enjoyR.pkr@gmail.com',
            'pokharelgajindra1234@gmail.com',
            'laxmi85576427@gmail.com',
            'tulasiramdasi@gmail.com',
            'narbadaparajuli04@gmail.com',
            'hari.tripathi21220@gmail.com',
            'gcmanhari@gmail.com',
            'karkigopichandra84@gmail.com',
            'mysankalpa@gmail.com',
            'dipendraacharya655@gmail.com',
            'laxmeesthamalla@gmail.com',
            '123palikhejoshi@gmail.com',
            'sumsmpk@gmail.com',
            'mankaji9000@gmail.com',
            'haridhungana021@gmail.com',
            'bsalsapkota@gmail.com',
        ];

    }
}
