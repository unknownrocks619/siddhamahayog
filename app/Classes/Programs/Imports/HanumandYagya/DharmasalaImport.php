<?php
namespace App\Classes\Programs\Imports\HanumandYagya;

use App\Models\Member;
use App\Models\ProgramGroupPeople;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DharmasalaImport implements ToCollection, WithStartRow, WithHeadingRow {


    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $collections)
    {
        $complier = [];
        foreach ($collections as $collection) {
            
            if ( ! isset ($collection['registration_code']) ) {
                continue;
            }
            $member = Member::find($collection['registration_code']);

            if (! $member ) {
                continue;
            }

            // check if this user is already in any groups.
            $groupPeople = ProgramGroupPeople::where('member_id',$member->getKey())
                                                ->where('is_parent',true)
                                                ->first();
            /**
             * If Found Update Dharmsala Info.
             */
            if ( $groupPeople )
            {
                // update id and profile photo.
                if ($member->memberIDMedia) {
                    $member->member_id_card = $member->memberIDMedia->getKey();
                }

                if ($member->profileImage) {
                    $member->profile_id = $member->profileImage->getKey();
                }

                if ($groupPeople->isDirty(['member_id_card','profile_id'])) {
                    $groupPeople->save();
                }
                

                /**
                 *  Also Update Photo from fa
                 */

                continue;
            }

            /**
             *  Insert New Recod
             */
        }
    }

    public function headingRow() : int {
        return 1;
    }
}