<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Classes\Helpers\ExcelExport\ExcelExportDownload;
use App\Classes\Helpers\ExcelExport\ExcelImportEmail;
use App\Classes\Helpers\ExcelExport\ExcelMultipleSheet;
use App\Classes\Helpers\ExcelExport\ExportFromView;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramGrouping;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

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

    public function familyGroup(Program $program) {
        ini_set('memory_limit',-1);
        $emailList = $this->downloadCompareList()->all();

        $groupingRecord = collect(ProgramGrouping::familyGrouping($program));

        $groupingRecord = $groupingRecord->filter(function($item) use ($emailList) {
            return ( ! in_array($item->email, $emailList) );
        });

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
        $emails = $this->downloadCompareList()->all();
        $students = collect($program->programStudentEnrolments(null));

        $students = $students->filter(function($item) use ($emails) {
            return (!in_array($item->email, $emails));
        });


        $params = [
            'data'  => $students,'program' => $program
        ];
        $sheet = [
            'All Program Member List' => ['view' =>'admin.programs.groups.student','params'=> $params ]
        ];

        $exportFromView =new ExcelMultipleSheet($sheet);
        return $exportFromView->download('program-student-list.xlsx');

    }

    public function downloadCompareList() {
        // get the list of email from excel file.
        $emailListImport = new ExcelImportEmail();
        $filePath  = storage_path('app'.DIRECTORY_SEPARATOR.'excel-processing'.DIRECTORY_SEPARATOR.'yagya-email-list.xlsx');
        Excel::import($emailListImport,$filePath,null,ExcelExcel::XLSX);
        return $emailListImport;
    }
}
