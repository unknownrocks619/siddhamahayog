<?php

namespace App\Console\Commands;

use App\Classes\Helpers\Str;
use App\Models\ProgramGrouping;
use App\Models\ProgramGroupPeople;
use App\Models\ProgramVolunteer;
use Illuminate\Console\Command;

class AddVolunteerToGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:volunteer';

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
        $volunteers = ProgramVolunteer::with(['availableDates','member','program'])->get();
        $volunteerGroup = ProgramGrouping::find(8);

        foreach ($volunteers as $volunteer) {
            $member = $volunteer->member;
            $program = $volunteer->program;

            echo 'Import Volunteer To '. $volunteer->getKey() . PHP_EOL;

            // check if volunteer already exists.
            $groupVolunteer = ProgramGroupPeople::where('group_id',$volunteerGroup->getKey())
                                                    ->where('is_parent',true)
                                                    ->where('member_id',$member->getKey())
                                                    ->first();
            /** 
             * If Volunteer exists check and update profile image only.
             */

            if ( $groupVolunteer ) {

                if ( ! $groupVolunteer->profile_id && $member->profileImage) {
                        $groupVolunteer->profile_id = $member->profileImage->getKey();
                        $groupVolunteer->save();
                }

                continue;
            }

            $groupVolunteer = new ProgramGroupPeople;
            $groupVolunteer->fill([
                'member_id' => $member->getKey(),
                'program_id' => $program->getKey(),
                'group_id'  => $volunteerGroup->getKey(),
                'phone_number'  => $member->phone_number,
                'email' => $member->email,
                'profile_id' => $member->profileImage?->getKey(),
                'verified'  => 0,
                'is_parent' => true,
                'group_uuid'    => Str::uuid(),
            ]);
            $full_name = ucwords(strtolower($member->first_name));

            if ($member->middle_name) {
                $full_name .= ' '.ucwords(strtolower($member->middle_name));
            }
            $full_name .= ' '. ucwords(strtolower($member->last_name));
            $groupVolunteer->full_name = $full_name;
            $groupVolunteer->save();
        }
    }
}
