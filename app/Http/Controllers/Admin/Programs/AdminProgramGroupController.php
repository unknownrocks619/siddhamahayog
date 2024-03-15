<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Classes\Helpers\ExcelExport\ExcelExportDownload;
use App\Classes\Helpers\ExcelExport\ExcelMultipleSheet;
use App\Classes\Helpers\ExcelExport\ExportFromView;
use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\ImageRelation;
use App\Models\Program;
use App\Models\ProgramGrouping;
use App\Models\ProgramGroupPeople;
use Illuminate\Http\Request;

class AdminProgramGroupController extends Controller
{
    //
    public function list(Program $program) {
        $groups = ProgramGrouping::withCount('groupMember')->where("program_id",$program->getKey())->get();
        return view('admin.programs.groups.list',['program' => $program,'groups' => $groups]);
    }

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
}
