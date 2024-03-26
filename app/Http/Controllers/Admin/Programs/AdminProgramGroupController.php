<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Classes\Helpers\ExcelExport\ExcelExportDownload;
use App\Classes\Helpers\ExcelExport\ExcelMultipleSheet;
use App\Classes\Helpers\ExcelExport\ExportFromView;
use App\Classes\Helpers\Image;
use App\Classes\Helpers\InterventionImageHelper;
use App\Http\Controllers\Admin\Members\MemberEmergencyController;
use App\Http\Controllers\Controller;
use App\Models\ImageRelation;
use App\Models\Images;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use App\Models\Program;
use App\Models\ProgramGrouping;
use App\Models\ProgramGroupPeople;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminProgramGroupController extends Controller
{
    //
    public function list(Program $program) {
        $groups = ProgramGrouping::withCount('groupMember')->where("program_id",$program->getKey())->get();
        return view('admin.programs.groups.list',['program' => $program,'groups' => $groups]);
    }

    /**
     * @param Program $program
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Program $program) {

        $request = request()->capture();

        if ($request->ajax() ) {
            $rules = [];

            foreach ($request->post('amount') as $index => $amount) {

                if ( ! isset ($rules[$amount]) ) {
                    $rules[$amount] = [];
                }

                $rules[$amount] = [
                    'operator'  => $request->post('operator')[$index],
                    'connector' => $request->post('connector')[$index],
                ];
            }
            $rules['rules'] = $rules;
            $rules['connector'] = $request->post('connector');

            $programGroup = new ProgramGrouping();

            $programGroup->fill([
                'program_id' => $program->getKey(),
                'batch_id' => $program->active_batch?->getKey(),
                'enable_auto_adding' => $request->post('auto_include'),
                'rules' => $rules,
                'group_name'    => $request->post('group_name')
            ]);

            if (! $programGroup->save() ) {
                return $this->json(false,'Failed to create group');
            }

            if ($request->file('card_sample') ) {

                $uploadedImage = Image::uploadImage($request->file('card_sample'),$programGroup);

                if ( isset ($uploadedImage[0]['relation']) && $uploadedImage[0]['relation'] instanceof ImageRelation) {
                    $imageRelation = $uploadedImage[0]['relation'];
                    $imageRelation->type = ProgramGrouping::IMAGE_TYPE;
                    $imageRelation->save();
                }

            }

            return $this->json(true,'Group Created.','redirect',['location' => route('admin.program.admin_program_group_edit',['program' => $program,'group' => $programGroup])]);

        }

        return view('admin.programs.groups.create',['program' => $program]);
    }

    /**
     * @param Program $program
     * @param ProgramGrouping $group
     * @param $tab
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Program $program, ProgramGrouping $group,$tab='general') {

        $request = request()->capture();

        if ($request->ajax() ) {

            $rules = [];

            foreach ($request->post('amount') as $index => $amount) {

                if ( ! isset ($rules[$amount]) ) {
                    $rules[$amount] = [];
                }

                $rules[$amount] = [
                    'operator'  => $request->post('operator')[$index],
                    'connector' => $request->post('connector')[$index],
                ];
            }
            $rules['rules'] = $rules;
            $rules['connector'] = $request->post('connector');


            $group->fill([
                'program_id' => $program->getKey(),
                'batch_id' => $program->active_batch?->getKey(),
                'enable_auto_adding' => $request->post('auto_include'),
                'rules' => $rules,
                'group_name'    => $request->post('group_name'),
                'id_card_print_width'  => $request->post('id_width'),
                'id_card_print_height' => $request->post('id_height'),
                'id_card_print_position_x' => $request->post('id_position_x'),
                'id_card_print_position_y'  => $request->post('id_position_y'),
                'enable_barcode'    => $request->post('enable_barcode') ?? 0,
                'barcode_print_width' => $request->post('barcode_width'),
                'barcode_print_height'  => $request->post('barcode_height'),
                'barcode_print_position_x'  => $request->post('barcode_position_x'),
                'barcode_print_position_y'  => $request->post('barcode_position_y'),
                'enable_personal_info'  => $request->post('enable_persononal') ?? 0,
                'personal_info_print_width' => $request->post('personal_info_width'),
                'personal_info_print_height'    => $request->post('personal_info_height'),
                'personal_info_print_position_x'    => $request->post("personal_info_position_x"),
                'personal_info_print_position_y'    => $request->post('personal_info_position_y'),
            ]);

            if (! $group->save() ) {
                return $this->json(false,'Failed to create group');
            }

            if ($request->file('card_sample') ) {

                $uploadedImage = Image::uploadImage($request->file('card_sample'),$group);

                if ( isset ($uploadedImage[0]['relation']) && $uploadedImage[0]['relation'] instanceof ImageRelation) {
                    $imageRelation = $uploadedImage[0]['relation'];
                    $imageRelation->type = ProgramGrouping::IMAGE_TYPE;
                    $imageRelation->save();
                }

            }

            /**
             * Insert ID Card Area.
             */
            return $this->json(true,'Group Created.','redirect',['location' => route('admin.program.admin_program_group_edit',['program' => $program,'group' => $group,'tab' => 'general'])]);

        }

        $tabs = [
            ['name'  => 'general','label' => "General"],
            ['name' => 'groups', 'label' => 'Groups'],
        ];

        $groups = ProgramGroupPeople::where('group_id',$group->getKey())
                                            ->with('families')
                                            ->where('is_parent',true);

        return view('admin.programs.groups.edit',['program' => $program,'group' => $group,'active_tab' => $tab,'tabs' => $tabs,'groups' => $groups]);
    }

    /**
     * @param Program $program
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function index(Program $program) {
        ini_set('memory_limit',-1);
        $groupingRecord = collect(ProgramGrouping::singleGrouping($program));
        $params = [
            'program'   => $program,
            'data'      => $groupingRecord
        ];
        $sheet = [
            'Single User' => ['view' =>'admin.programs.groups.single','params'=> $params ]
        ];

        $collectRecord = $groupingRecord->groupBy('country_name');
        $byGender = $groupingRecord->groupBy('gender');

        foreach ($collectRecord as $country_name => $country_record) {
            $sheet_name = $country_name != '' ? $country_name : 'Country Not Set';
            $sheet[$sheet_name] = [
                'view' => 'admin.programs.groups.single',
                'params'    => ['data' => $country_record,'program' => $program]
            ];
        }

        foreach ($byGender as $gender => $country_record) {

            $sheet_name = $gender != '' ? ucwords($gender) : 'Gender Not Set';
            $sheet[$sheet_name] = [
                'view' => 'admin.programs.groups.single',
                'params'    => ['data' => $country_record,'program' => $program]
            ];
        }

        // now make a group of 4 based on gender


        $exportFromView =new ExcelMultipleSheet($sheet);
        return $exportFromView->download('single-entry.xlsx');
    }

    /**
     * @param Program $program
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function familyGroup(Program $program) {
        ini_set('memory_limit',-1);

        $groupingRecord = collect(ProgramGrouping::familyGrouping($program));
        $params = [
            'program'   => $program,
            'data'      => $groupingRecord
        ];

        $sheet = [
            'All Family Member' => ['view' =>'admin.programs.groups.family','params'=> $params ]
        ];

        $collectRecord = $groupingRecord->groupBy('country_name');
        $byGender = $groupingRecord->groupBy('gender');

        foreach ($collectRecord as $country_name => $country_record) {
            $sheet_name = $country_name != '' ? $country_name : 'Country Not Set';
            $sheet[$sheet_name] = [
                'view' => 'admin.programs.groups.family',
                'params'    => ['data' => $country_record,'program' => $program]
            ];
        }

        foreach ($byGender as $gender => $country_record) {

            $sheet_name = $gender != '' ? ucwords($gender) : 'Gender Not Set';
            $sheet[$sheet_name] = [
                'view' => 'admin.programs.groups.family',
                'params'    => ['data' => $country_record,'program' => $program]
            ];
        }

        $exportFromView =new ExcelMultipleSheet($sheet);
        return $exportFromView->download('family-entry.xlsx');
    }

    /**
     * @param Program $program
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function downloadProgramStudent(Program $program) {
        $students = $program->programStudentEnrolments();
        $params = [
            'data'  => $students,'program' => $program
        ];
        $sheet = [
            'All Program Member List' => ['view' =>'admin.programs.groups.student','params'=> $params ]
        ];

        $exportFromView =new ExcelMultipleSheet($sheet);
        return $exportFromView->download('program-student-list.xlsx');

    }


    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople $people
     * @return \Illuminate\Http\Response
     */
    public function updateFamilyGroup(Request $request, Program $program, ProgramGrouping $group, ProgramGroupPeople $people) {
        $request = request()->capture();

        $saveID = [];

        foreach ($request->post('families') as $family) {

                                // check if this family is already included in the
            $familyExists = ProgramGroupPeople::where('member_id',$family)
                                                ->where('is_parent',false)
                                                ->where('id_parent',$people->getKey())
                                                ->where('group_id',$group->getKey())
                                                ->first();
            /**
             * Do Nothing.
             */
            if ( $familyExists ) {
                $saveID[] = $familyExists->getKey();
                continue;
            }



            /**
             * Get Family Info.
             */
            $familyMember = MemberEmergencyMeta::where('id', $family)->first();

            /**
             * Validate required field
             */
            $fillable = [
                'full_name' => $familyMember->contact_person,
                'phone_number'  => $familyMember->phone_number,
                'email'         => $familyMember->email,
                'gotra'     => $familyMember->gotra,
            ];

            Validator::make($fillable,[
                'full_name' => 'required|string',
                'phone_number'  => 'requried',
                'gotra'     => 'required',
            ]);

            /**
             *
             */
            $newFamily = new ProgramGroupPeople();

            $newFamily->fill([
                'member_id' => $family,
                'program_id'    => $program->getKey(),
                'group_id'      => $group->getKey(),
                'full_name'     => $familyMember->contact_person,
                'phone_number'  => $familyMember->phone_number,
                'email'         => $familyMember->email,
                'id_parent'     => $people->getKey(),
                'order'         => (ProgramGroupPeople::where('id_parent',$people->getKey())->max('order')  ??  0) + 1,
                'is_card_generated' => false,
                'is_parent'     => false,
            ]);

            if ( ! $newFamily->save() ) {
                continue;
            }
            $newFamily->group_uuid = \App\Classes\Helpers\Str::uuid($newFamily);
            $newFamily->save();

            $saveID[] = $newFamily->getKey();
        }
        // remove other groups.
        ProgramGroupPeople::where('id_parent',$people->getKey())->whereNotIn('id',$saveID)->delete();
        $view = view('admin.programs.groups.tabs.people-card',['people' => $people])->render();
        return $this->json(true,'Family Information Updated.','updateFamilyGroup',['cardID' => 'groupPeople_'.$people->getKey(),'view' => $view]);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople $people
     * @return \Illuminate\Http\Response
     */
    public function addFamilyGroup(Request $request, Program $program, ProgramGrouping $group, ProgramGroupPeople $people) {
        $request = request()->capture();

        $saveID = [];
        $member = Member::where('id',$people->member_id)->first();
        $addMembers = (new MemberEmergencyController())->bulkInsert($request,$member,true);

        $familyMembers = MemberEmergencyMeta::whereIn('id',$addMembers)->get();

        foreach ($familyMembers as $familyMember)  {
            $newFamily = new ProgramGroupPeople();

            $newFamily->fill([
                'member_id'     => $familyMember->getKey(),
                'program_id'    => $program->getKey(),
                'group_id'      => $group->getKey(),
                'full_name'     => $familyMember->contact_person,
                'phone_number'  => $familyMember->phone_number,
                'email'         => $familyMember->email,
                'id_parent'     => $people->getKey(),
                'order'         => (ProgramGroupPeople::where('id_parent',$people->getKey())->max('order')  ??  0) + 1,
                'is_card_generated' => false,
                'is_parent'     => false,
            ]);

            $newFamily->save();

            $newFamily->group_uuid    =  \App\Classes\Helpers\Str::uuid($newFamily);
            $newFamily->save();
        }

        // remove other groups.
        $view = view('admin.programs.groups.tabs.people-card',['people' => $people])->render();
        return $this->json(true,'Family Information Updated.','updateFamilyGroup',['cardID' => 'groupPeople_'.$people->getKey(),'view' => $view]);
    }

    public function generateIDCard(Program $program, ProgramGrouping $group, ProgramGroupPeople $people)
    {

        if (!$people->profile) {
            return $this->json(false, 'User Do not have any profile image');
        }

        $userResizedImage = $people->resized_image;

        if (!$userResizedImage) {
            // get sample Image.
            $sampleImage = Image::getImageAsSize($people->group->mediaSample->filepath, 'org');
            $userResizedImage = Image::resizeImage(Image::getImageAsSize($people->profile->filepath, 'org'), $group->id_card_print_width, $group->id_card_print_height);
            $people->resized_image = $userResizedImage;
            $people->save();
        }

        // check if barcode is generated
        $barcodeImage = $people->barcode_image;

        if (!$barcodeImage) {
            $barcodeImage = Image::generateBarcode($people->group_uuid, $group->barcode_print_width, $group->barcode_print_height);
            $people->barcode_image = $barcodeImage;
            $people->save();
        }

        $idCard = $people->generated_id_card;

        if (!$idCard) {
            //
            $sampleImage = $group->mediaSample;
            $params = [
                asset($userResizedImage) => [
                    'positionX' => $group->id_card_print_position_x,
                    'positionY' => $group->id_card_print_position_y,
                ],
                asset($barcodeImage) => [
                    'positionX' => $group->barcode_print_position_x - 10,
                    'positionY' => $group->barcode_print_position_y
                ]
            ];

            $interventionImageInstance = InterventionImageHelper::insertImage(Image::getImageAsSize($sampleImage->filepath, 'org'), $params);

            if ($interventionImageInstance) {
                $people->generated_id_card = $interventionImageInstance;
                $people->save();
            }
            InterventionImageHelper::insertText(asset($interventionImageInstance), [
                $people->full_name,
                'Kathmandu, Nepal',
                'Phone: ' . $people->phone_number,
                'Room: Laxman Sadhan, L201'
            ],
                $group->personal_info_print_width,
                $group->personal_info_print_height,
                $group->personal_info_print_position_x,
                $group->personal_info_print_position_y
            );

        }

        $people->is_card_generated = true;
        $people->save();
    }
}
