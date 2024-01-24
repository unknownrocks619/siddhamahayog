<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Classes\Helpers\ExcelExport\ExcelExportDownload;
use App\Classes\Helpers\ExcelExport\ExcelMultipleSheet;
use App\Classes\Helpers\ExcelExport\ExportFromView;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramGrouping;
use Illuminate\Http\Request;

class AdminProgramGroupController extends Controller
{
    //

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


}
