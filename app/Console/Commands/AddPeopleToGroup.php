<?php

namespace App\Console\Commands;

use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\MemberEmergencyMeta;
use App\Models\Program;
use App\Models\ProgramGrouping;
use App\Models\ProgramGroupPeople;
use App\Models\ProgramStudentFee;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddPeopleToGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:user:group {programID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add People to the group according the rules of the group';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $program = Program::find($this->argument('programID'));
        // get all groups based on the id.
        $groups = ProgramGrouping::where('program_id',$program->getKey())->where('enable_auto_adding',TRUE)->get();
        foreach ($groups as $group) {

            echo 'Import Users into '. $group->group_name . PHP_EOL;
            // check rules doesn't exists. do not import.
            if ( ! $group->rules) {
                continue;
            }

            // get rules now.
            $rules = collect($group->rules['rules'])->map(function($item,$amount) {
                $item['amount'] = $amount;
                return $item;
            })->sortKeys();
            
            $groupUsers = ProgramStudentFee::where('program_id', $group->program_id)
                                                        ->where('student_batch_id',$group->batch_id)
                                                        ->where('total_amount' , '>=', $rules->first()['amount'])
                                                        ->where('total_amount' ,'<=' , $rules->last()['amount'])
                                                        ->with(['member' => function($query) {
                                                            $query->with(['memberIDMedia','profileImage']);
                                                        }])
                                                        ->get();
            $peopleArrangementOrder = ProgramGroupPeople::where('group_id',$group->getKey())->max('order') ?? 0;

            foreach ($groupUsers as $groupUser) {
                // check if user is already in list.
                $groupPeople = ProgramGroupPeople::where('group_id',$group->getKey())
                                                ->where('program_id',$program->getKey())
                                                ->where('member_id', $groupUser->student_id)
                                                ->first();
                
                /**
                 *  Already Added.
                 */
                if( $groupPeople ) {
                    continue;
                }

                    $groupPeople = new ProgramGroupPeople();

                    $groupPeople->fill([
                        'member_id' => $groupUser->student_id,
                        'group_id'  => $group->getKey(),
                        'program_id'    => $program->getKey(),
                        'is_parent' => true,
                        'order' => $peopleArrangementOrder,
                        'group_uuid'    => Str::uuid(),
                        'is_card_generated' => false,
                        'full_name' => ucwords($groupUser->full_name),
                        'phone_number'  => $groupUser->phone_number,
                    ]);

                    $groupPeople->save();

                // now check if dharmasa information is avilable for this user.
                $bookingInfo = DharmasalaBooking::where('member_id',$groupPeople->studen_id)
                                                ->where('status',DharmasalaBooking::RESERVED)
                                                ->latest()
                                                ->first();
                
                if ( $bookingInfo ) {
                    $groupPeople->dharmasala_booking_id = $bookingInfo->getKey();
                    $groupPeople->dharmasala_uuid = $bookingInfo->uuid;
                }
                
                // now import user profile Picture, and ID Card.

                $groupPeople->profile_id = $groupUser->member->profileImage?->getKey();

                /**
                 * Add / Update Family Members.
                 */
                $familyMembers = MemberEmergencyMeta::where('verified_family',true)
                                                        ->where('member_id',$group->member_id)
                                                        ->get();
                
                $familyOrder = 0;

                foreach ($familyMembers as $familyMember) {
                    // check if this member is already in the people list.
                    $groupFamilyPeople = ProgramGroupPeople::where('id_parent',$groupPeople->getKey())
                                                            ->where('member_id', $familyMember->getKey())
                                                            ->first();
                    if ( ! $groupFamilyPeople ) {

                        $groupFamilyPeople = new ProgramGroupPeople();
                        $groupFamilyPeople->fill([
                            'member_id' => $familyMember->getKey(),
                            'group_id' => $group->getKey(),
                            'program_id'    => $program->getKey(),
                            'full_name' => $familyMember->contact_person,
                            'phone_number'  => $familyMember->phone_number,
                            'email' => $familyMember->email_address,
                            'order' => $familyOrder,
                            'group_uuid'    => Str::uuid(),
                            'is_parent' => false,
                            'id_parent' => $groupPeople->getKey()
                        ]);

                        $groupFamilyPeople->save();
                    }
                    
                    // check if this family member has profile picture.
                    $memberPhoto = $familyMember->profileImage;
                    if ($memberPhoto ) {
                        $groupFamilyPeople->profile_id = $memberPhoto->getKey();
                    }
                    
                    /**
                     * Check for dharmasal booking info
                     */
                    $dharmasalaBooking = DharmasalaBooking::where('member_emergency_meta_id',$familyMember->getKey())
                                                            ->where('status',DharmasalaBooking::RESERVED)
                                                            ->latest()
                                                            ->first();

                    if ($dharmasalaBooking) {
                        $groupFamilyPeople->dharmasala_booking_id = $dharmasalaBooking->getKey();
                        $groupFamilyPeople->dharmasala_uuid = $dharmasalaBooking->uuid;
                    }

                    $groupFamilyPeople->save();
                    $familyOrder++;

                }
                $groupPeople->save();

                $peopleArrangementOrder++;

            }
        }
    }
}
