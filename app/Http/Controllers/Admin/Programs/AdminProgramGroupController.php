<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Classes\Helpers\ExcelExport\ExcelMultipleSheet;
use App\Classes\Helpers\Image;
use App\Classes\Helpers\InterventionImageHelper;
use App\Classes\Helpers\Str;
use App\Http\Controllers\Admin\Members\MemberEmergencyController;
use App\Http\Controllers\Controller;
use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use App\Models\ImageRelation;
use App\Models\Images;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use App\Models\Program;
use App\Models\ProgramGrouping;
use App\Models\ProgramGroupPeople;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminProgramGroupController extends Controller
{
    //
    /**
     * @param Program $program
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(Program $program) {
        $groups = ProgramGrouping::withCount('groupMember')
                                ->where("program_id",$program->getKey())
                                ->where('id_parent',false)
                                ->get();
        return view('admin.programs.groups.list',['program' => $program,'groups' => $groups]);
    }

    /**
     * @param Program $program
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(Program $program, ?ProgramGrouping $group) {

        $request = request()->capture();

        if ($request->ajax() ) {
            $rules = [];

            foreach ($request->post('amount') ?? [] as $index => $amount) {

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
                'group_name'    => $request->post('group_name'),
                'actual_print_height' => $request->post('print_size_height'),
                'actual_print_width'  =>$request->post('print_size_width'),
                'id_parent'     => 0,
                'print_primary_colour'  => $request->post('primary_colour')
            ]);

            if ($group?->getKey()) {

                $programGroup->id_parent = $group->getKey();
                $programGroup->enable_auto_adding = false;
                $programGroup->rules = [];
                $programGroup->print_primary_colour = $group->print_primary_colour;
            }

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

                if (isset ($uploadedImage[0]['image']) && $uploadedImage[0]['image'] instanceof Images ) {
                    $image = ($uploadedImage[0]['image'])->replicate();
                    // resize Iimage
                    $resized = Image::resizeImage(Image::getImageAsSize($image->filepath,'org'),$programGroup->actual_print_width,$programGroup->actual_print_height);
                    $image->filepath = $resized;
                    $image->save();

                    $imageRelation = ($uploadedImage[0]['relation'])->replicate();
                    $imageRelation->image_id = $image->getKey();
                    $imageRelation->type = ProgramGrouping::IMAGE_RESIZED;
                    $imageRelation->save();
                }

            }

            return $this->json(true,'Group Created.',$group?->getKey() ? 'reload' : 'redirect',['location' => route('admin.program.admin_program_group_edit',['program' => $program,'group' => $programGroup])]);

        }

        return view('admin.programs.groups.create',['program' => $program]);
    }

    /**
     * @param Program $program
     * @param ProgramGrouping $group
     * @param $tab
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Program $program, ProgramGrouping $group,$tab='general',?ProgramGrouping $parentGroup=null) {

        $request = request()->capture();

        if ($request->ajax() ) {

            $rules = [];

            if (! $parentGroup?->getKey() ) {

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
            }

            $group->fill([
                'id_card_print_width'  => $request->post('id_width'),
                'id_card_print_height' => $request->post('id_height'),
                'id_card_print_position_x' => $request->post('id_position_x'),
                'id_card_print_position_y'  => $request->post('id_position_y'),
                'barcode_print_width' => $request->post('barcode_width'),
                'barcode_print_height'  => $request->post('barcode_height'),
                'barcode_print_position_x'  => $request->post('barcode_position_x'),
                'barcode_print_position_y'  => $request->post('barcode_position_y'),
                'enable_personal_info'  => $request->post('enable_persononal') ?? 0,
                'personal_info_print_width' => $request->post('personal_info_width'),
                'personal_info_print_height'    => $request->post('personal_info_height'),
                'personal_info_print_position_x'    => $request->post("personal_info_position_x"),
                'personal_info_print_position_y'    => $request->post('personal_info_position_y'),
                'print_primary_colour'              => $request->post('primary_colour')
            ]);

            if ( $parentGroup?->getKey() ) {
                $group->enable_auto_adding =false;
                $group->group_name = $group->group_name;
                $group->enable_barcode = false;
                $group->print_primary_colour = $parentGroup->print_primary_colour;
            } else {
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

            }


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

                if (isset ($uploadedImage[0]['image']) && $uploadedImage[0]['image'] instanceof Images ) {
                    $image = ($uploadedImage[0]['image'])->replicate();
                    // resize Iimage
                    $resized = Image::resizeImage(Image::getImageAsSize($image->filepath,'org'),$group->actual_print_width,$group->actual_print_height);
                    $image->filepath = $resized;
                    $image->save();

                    $imageRelation = ($uploadedImage[0]['relation'])->replicate();
                    $imageRelation->image_id = $image->getKey();
                    $imageRelation->type = ProgramGrouping::IMAGE_RESIZED;
                    $imageRelation->save();
                }

            }


            if ( $group->mediaSample && ! $group->resizedImage) {
                $image = $group->mediaSample->replicate();
                $resizedImage = Image::resizeImage(Image::getImageAsSize($image->filepath,'org'),$group->actual_print_width,$group->actual_print_height);
                $image->filepath = $resizedImage;
                unset($image->laravel_through_key);
                $image->save();

                $imageRelation = ImageRelation::where('image_id',$group->mediaSample->getKey())->first();
                $imageRelation = $imageRelation->replicate();
                $imageRelation->type = ProgramGrouping::IMAGE_RESIZED;
                $imageRelation->image_id = $image->getKey();
                $imageRelation->save();
            }

            /**
             * Insert ID Card Area.
             */
            return $this->json(true,'Group Created.','redirect',['location' => route('admin.program.admin_program_group_edit',['program' => $program,'group' => ! $parentGroup?->getKey() ? $group : $parentGroup,'tab' => 'general'])]);

        }

        $tabs = [
            ['name'  => 'general','label' => "General"],
            ['name' => 'groups', 'label' => 'Groups'],
        ];

        $view = 'card';
        if (request()->has('view') && request()->get('view')) {
            $view = 'table';
        }

        $groups = ProgramGroupPeople::where('group_id',$group->getKey())
                                            ->with('families')
                                            ->where('is_parent',true);

        return view('admin.programs.groups.edit',
                                        [
                                            'program' => $program,
                                            'group' => $group,
                                            'active_tab' => $tab,
                                            'tabs' => $tabs,
                                            'groups' => $groups,
                                            'view'  => $view
                                        ]);
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
    public function updateFamilyGroup(Request $request, Program $program, ProgramGrouping $group, ProgramGroupPeople $people, string $view='card') {
        $request = request()->capture();

        $saveID = [];

        foreach ($request->post('families') ?? [] as $family) {

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
        if ($view == 'card') {
            $viewBlade = view('admin.programs.groups.tabs.people-card',['people' => $people])->render();
        } else {
            $viewBlade = view('admin.programs.groups.tabs.people-table',['people' => $people])->render();
        }
        return $this->json(true,'Family Information Updated.','updateFamilyGroup',['cardID' => 'groupPeople_'.$people->getKey(),'view' => $viewBlade]);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople $people
     * @return \Illuminate\Http\Response
     */
    public function addFamilyGroup(Request $request, Program $program, ProgramGrouping $group, ProgramGroupPeople $people, string $view='card') {

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
        if ($view == 'card') {
            $viewBlade = view('admin.programs.groups.tabs.people-card',['people' => $people])->render();
        } else {
            $viewBlade = view('admin.programs.groups.tabs.people-table',['people' => $people])->render();
        }
        return $this->json(true,'Family Information Updated.','updateFamilyGroup',['cardID' => 'groupPeople_'.$people->getKey(),'view' => $viewBlade]);
    }

    /**
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople $people
     * @param bool $resetCard
     * @return \Illuminate\Http\Response
     */
    public function generateIDCard(Program $program, ProgramGrouping $group, ProgramGroupPeople $people, bool $resetCard = false)
    {

        if (!$people->profile) {
            return $this->json(false, 'User Do not have any profile image');
        }

        if (! $people->is_parent) {
            $group = $group->children()->first();
        }

        /**
         * Generate Barcode info:
         */
        dump ('Generating Barcode for: ' . $people->getKey());

        $userResizedImage = $people->resized_image;

        if ($resetCard == true) {
            $people->barcode_image = null;
            $people->is_card_generated = false;
            $people->generated_id_card = null;
        }

        if (!$userResizedImage) {
            // get sample Image.

            $sampleImage = asset($group->resizedImage->filepath, (config('app.env') == 'local') ? false : true);

            $userResizedImage = Image::resizeImage(Image::getImageAsSize($people->profile->filepath, 'org'), $group->id_card_print_width, $group->id_card_print_height);
            $people->resized_image = $userResizedImage;
            $people->save();
        }

        // check if barcode is generated
        $barcodeImage = $people->barcode_image;
        if (! $barcodeImage ) {

            $barcodeImage = Image::generateBarcode($people->group_uuid, $group->barcode_print_width, $group->barcode_print_height);
            $people->barcode_image = $barcodeImage;
            $people->save();
        }

        $idCard = $people->generated_id_card;
        if (!$idCard) {
            //
            $sampleImage = asset($group->resizedImage->filepath, (config('app.env') == 'local') ? false : true);

            $params = [
                asset($userResizedImage) => [
                    'positionX' => $group->id_card_print_position_x-15,
                    'positionY' => $group->id_card_print_position_y,
                ],
                asset($barcodeImage) => [
                    'positionX' => $group->barcode_print_position_x - 10,
                    'positionY' => $group->barcode_print_position_y
                ]
            ];

            $interventionImageInstance = InterventionImageHelper::insertImage($sampleImage, $params);


            if ($interventionImageInstance) {
                $people->generated_id_card = $interventionImageInstance;
                $people->save();
            }

            $text = [
                $people->full_name,
                $people->address,
                $people->phone_number
            ];

            if (! $people->is_parent ) {
                $text[1] = $people->parentFamily?->address;
            }

            if ($people->dharmasala_booking_id) {
                $dharmsala = $people->dharmasala;
                $text[] = $dharmsala->building_name . $dharmsala->room_number. "(".$dharmsala->floor_name.")";
            }

            InterventionImageHelper::textToCanva(asset($interventionImageInstance), $text,
                $group->personal_info_print_width,
                $group->personal_info_print_height,
                $group->personal_info_print_position_x-10,
                $group->personal_info_print_position_y,
                $group->print_primary_colour
            );

        }

        $people->is_card_generated = true;
        $people->save();


        /**
         * Also Generate ID Card For Family that is included.
         */

         foreach ($people->families ?? [] as $family) {

            /**
             *
             */
            if ( $group->id_parent) {
                $group = ProgramGrouping::find($group->id_parent);
            }

            $this->generateIDCard($program,$group,$family,$resetCard);
         }


         return $this->json(true,'Card Generated');

    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople $people
     * @return \Illuminate\Http\Response
     */
    public function updateDharamasaBooking(Request $request, Program $program, ProgramGrouping $group, ProgramGroupPeople $people) {
        // check if this user info is already available in dharmasala booking process.


        if ( $people->dharmasala_booking_id) {

            $peopleDharmasala = DharmasalaBooking::find($people->dharmasala_booking_id);
        } else {

            $peopleDharmasala = DharmasalaBooking::where('member_id',$people->member_id)
                                                    ->where('status',DharmasalaBooking::RESERVED)
                                                    ->latest()
                                                    ->first();
        }


        $room = DharmasalaBuildingRoom::where('id',$request->post('room_number'))->first();
        $floor = $room->floor;
        $building = $room->building;

        if ( ! $peopleDharmasala ) {
            $peopleDharmasala = new DharmasalaBooking();
        }
        $peopleDharmasala->member_id = $people->member_id;
        $peopleDharmasala->room_id  = $room->getKey();
        $peopleDharmasala->floor_id = $floor->getKey();
        $peopleDharmasala->building_id = $building->getKey();

        $peopleDharmasala->full_name = $people->full_name;
        $peopleDharmasala->phone_number = $people->phone_number;
        $peopleDharmasala->email = $people->email;
        $peopleDharmasala->room_number = $room->room_number;
        $peopleDharmasala->building_name = $building->building_name;
        $peopleDharmasala->floor_name = $floor->floor_name;
        $peopleDharmasala->check_in = $request->post('check_in_date');
        $peopleDharmasala->check_out = $request->post('check_out_date');
        $peopleDharmasala->profile = $people->profile_id;
        $peopleDharmasala->id_card = $people->member_id_card;
        $peopleDharmasala->status = DharmasalaBooking::RESERVED;
        $peopleDharmasala->uuid = $people->group_uuid;
        $peopleDharmasala->save();

        $people->dharmasala_booking_id = $peopleDharmasala->getKey();
        $people->update();

        /**
         * Insert Family Member Detail as welll.
         */
        $includedFamily = [];

        if (is_array($request->post('includeFamily')) && count($request->post('includeFamily')) ) {

            $includedFamily = ProgramGroupPeople::whereIn('id',array_keys($request->post('includeFamily')))->with(['dharmasala'])->get();
        }

        /**
         * Dharmasala For Family
         * Same as Main Parent
         */
        foreach ($includedFamily as $family) {

            if ($family->dharmasala) {
                $familyDharmaSalaBooking = $family->dharmasala;
            } else {

                $familyDharmaSalaBooking = DharmasalaBooking::where('member_emergency_meta_id',$family->member_id)
                                                    ->where('status',DharmasalaBooking::RESERVED)
                                                    ->latest()
                                                    ->first();
            }

            if ( ! $familyDharmaSalaBooking ) {
                $familyDharmaSalaBooking = new DharmasalaBooking();
            }

            $familyDharmaSalaBooking->fill([
                'room_id'  => $room->getKey(),
                'floor_id' => $floor->getKey(),
                'building_id' => $building->getKey(),

                'full_name' => $family->full_name,
                'phone_number' => $family->phone_number,
                'email' => $family->email,
                'room_number' => $room->room_number,
                'building_name' => $building->building_name,
                'floor_name' => $floor->floor_name,
                'check_in' => $request->post('check_in_date'),
                'check_out' => $request->post('check_out_date'),
                'profile' => $family->profile_id,
                'id_card' => $family->member_id_card,
                'status' => DharmasalaBooking::RESERVED,
                'uuid' => $family->group_uuid,
                'id_parent' => $peopleDharmasala->getKey(),
                'relation_with_parent' => $family->parent_relation,
                'member_emergency_meta_id'  => $family->member_id
            ]);

            $familyDharmaSalaBooking->save();

            $family->dharmasala_booking_id = $familyDharmaSalaBooking->getKey();
            $family->update();
        }


         /**
          * Insert Sepearate detail.
          */

          foreach ($request->post('family_room_number') as $familyID => $roomNumber) {

            # If check in & check is not Available continue.
            if (  ! isset($request->post("family_check_in_date")[$familyID]) || ! isset($request->post('family_check_in_date')[$familyID])) {
                continue;
            }


            $familyCheckInDate = $request->post('family_check_in_date')[$familyID];
            $familyCheckOutDate = $request->post('family_check_out_date')[$familyID];

            if (is_null($familyCheckInDate) || is_null($familyCheckOutDate) ) {
                continue;
            }

            $family = ProgramGroupPeople::with(['dharmasala'])->find($familyID);

            if ($family->dharmasala) {
                $familyDharmasala = $family->dharmasala;
            } else {
                $familyDharmasala = DharmasalaBooking::where('member_emergency_meta_id',$people->member_id)
                                                        ->where('id_parent',$peopleDharmasala->getKey())
                                                        ->where('status',DharmasalaBooking::RESERVED)
                                                        ->latest()->first();

            }


            $room = DharmasalaBuildingRoom::where('id',$roomNumber)->first();
            $floor = $room->floor;
            $building = $room->building;

            if ( ! $familyDharmasala ) {
                $familyDharmasala = new DharmasalaBooking();
            }

            $familyDharmasala->fill([
                'room_id'  >= $room->getKey(),
                'floor_id' => $floor->getKey(),
                'building_id' => $building->getKey(),

                'full_name' => $family->full_name,
                'phone_number' => $family->phone_number,
                'email' => $family->email,
                'room_number' => $room->room_number,
                'building_name' => $building->building_name,
                'floor_name' => $floor->floor_name,
                'check_in' => $request->post('check_in_date'),
                'check_out' => $request->post('check_out_date'),
                'profile' => $family->profile_id,
                'id_card' => $family->member_id_card,
                'status' => DharmasalaBooking::RESERVED,
                'uuid' => $family->group_uuid,
                'id_parent' => $peopleDharmasala->getKey(),
                'relation_with_parent' => $family->parent_relation
            ]);

            $familyDharmasala->save();

            $family->dharmasala_booking_id = $familyDharmasala->getKey();
            $family->update();

        }
        $view = view('admin.programs.groups.tabs.people-card',['people' => $people])->render();

        return $this->json(true,"Group Dharmasal information updated.","updateFamilyGroup",['cardID' => 'groupPeople_'.$people->getKey(),'view' => $view]);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople|null $people
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function viewCard(Request $request, Program $program, ProgramGrouping $group, ?ProgramGroupPeople $people) {

        $printCards = [];
        $cards = [];

        if ($people?->getKey() ) {
            if (! $people->is_card_generated ) {
                return $this->json(false,'Sorry Card has not been genered yet.');
            }

            $cards[] = asset($people->generated_id_card);

            if ($people->families()->count() ) {
                foreach ($people->families as $family) {

                    if ( ! $family->is_card_generated ) {
                        continue;
                    }

                    $cards[] = asset($family->generated_id_card);
                }
            }
        } elseif($request->get('bulkPrint') ) {
            $registrationCode = explode(',',$request->get('bulkPrint'));
            $peoples = ProgramGroupPeople::where('is_card_generated',true)
                                            ->where('is_parent', true)
                                            ->where('group_id', $group->getKey())
                                            ->whereIn('member_id',$registrationCode)
                                            ->get();

            foreach ($peoples as $people ) {

                $cards[] = asset($people->generated_id_card);

                if ($people->families()->count() ) {

                    foreach ($people->families as $family) {

                        if ( ! $family->is_card_generated ) {
                            continue;
                        }

                        $cards[] = asset($family->generated_id_card);
                    }
                }

            }


        } else {
            $peoples = ProgramGroupPeople::where('is_card_generated',true)
                                            ->where('is_parent',true)
                                            ->where('group_id',$group->getKey())
                                            ->get();

            foreach ($peoples as $people ) {

                $cards[] = asset($people->generated_id_card);

                if ($people->families()->count() ) {

                    foreach ($people->families as $family) {

                        if ( ! $family->is_card_generated ) {
                            continue;
                        }

                        $cards[] = asset($family->generated_id_card);
                    }
                }

            }
        }

        $printCards = array_chunk($cards,4);


        return view('admin.programs.groups.view-card',['printCards' => $printCards,'program' => $program,'group' => $group]);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @param ProgramGroupPeople $people
     * @return void
     */
    public function updateVerification(Request $request, Program $program, ProgramGrouping $group, ProgramGroupPeople $people) {

        $people->verified = $request->post('verified') == 'true' ? 1 : 0;
        $people->save();
        return;
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchGroupMember(Request $request, Program $program, ProgramGrouping $group) {

        $members = ProgramStudent::all_program_student($program,$request->member,15);
        return view('admin.programs.groups.partials.search-result',['program' => $program,'members' => $members,'group' => $group]);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addMemberToGroup(Request $request, Program $program, ProgramGrouping $group) {

        /**
         * Check if member is already available
         */
        $groupMember = ProgramGroupPeople::where('group_id',$group->getKey())
                                            ->where('member_id', $request->post('memberID'))
                                            ->where('is_parent', true)
                                            ->first();

        $member = Member::with(['emergency_contact','countries'])->find($request->post('memberID'));

        if ( ! $groupMember ) {
            $groupMember = new ProgramGroupPeople();
            $groupMember->fill([
                'member_id' => $member->getKey(),
                'group_id'  => $group->getKey(),
                'program_id'    => $program->getKey(),
                'is_parent' => true,
                'phone_number'  => $member->phone_number,
                'email' => $member->email,
                'full_name' => $member->full_name
            ]);

            $country = $member->countries?->name;

            if ( ! $country ) {
                $country .= $member->country;
            }

            $country .= ', ' .$member->city;
            $country .= ', ';
            $country .= $member->address ? $member->address->street_address : '';

            $groupMember->address = $country;
            $groupMember->group_uuid = \App\Classes\Helpers\Str::uuid();
            $groupMember->is_card_generated = false;
            $groupMember->generated_id_card = false;


            if ($member->memberIDMedia) {
                $groupMember->member_id_card = $member->memberIDMedia->getKey();
            }

            if ($member->profileImage) {
                $groupMember->profile_id = $member->profileImage->getKey();
            }

            $groupMember->save();
        }

        $families = $member->emergency_contact()->whereIn('id',$request->post('families') ?? [])->get();

        foreach ($families as $family) {
            // check if this family member has already been added.
            $groupPeople = ProgramGroupPeople::where('group_id',$group->getKey())
                                                ->where('member_id',$family->getKey())
                                                ->where('is_parent',false)
                                                ->where('id_parent',$groupMember->getKey())
                                                ->first();
            if ( ! $groupPeople ) {
                $groupPeople = new ProgramGroupPeople;
                $groupPeople->fill([
                    'member_id' => $family->getKey(),
                    'program_id'    => $program->getKey(),
                    'group_id'  => $group->getKey(),
                    'full_name' => $family->contact_person,
                    'phone_number'  => $family->phone_number,
                    'is_parent' => false,
                    'address' => $groupMember->address,
                    'group_uuid'    => Str::uuid(),
                    'parent_relation'   => $family->relation,
                    'email' => $family->email_address,
                    'id_parent' => $groupMember->getKey()
                ]);

                $familyPhoto = $family->profileImage;

                if ($familyPhoto) {
                    $groupPeople->profile_id = $familyPhoto->getKey();
                }

                $groupPeople->save();

            }
        }
        return response([
            "success" => true,
            "message" => "Member Enrolled.",
            "redirect" => true,
            "ajax" => true,
        ]);
    }

    /**
     * @param Request $request
     * @param Program $program
     * @param ProgramGrouping $group
     * @return \Illuminate\Http\Response
     */
    public function deleteGroup(Request $request, Program $program, ProgramGrouping $group) {
        $group->delete();
        if ($group->id_parent ) {
            return $this->json(true,'Child Group Deleted.','reload');
        }

        $group->children()->delete();
        return $this->json(true,'Group Deleted.','redirect',['location' => route('admin.program.admin_program_grouping_list',['program' => $program])]);
    }
}
