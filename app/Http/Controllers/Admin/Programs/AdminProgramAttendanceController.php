<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\AttendanceDateSheet;
use App\Models\Live;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdminProgramAttendanceController extends Controller
{
    //

    public function index(Request $request, Program $program)
    {
        set_time_limit(120);
        $program->load(['sections']);
        $sections = $program->sections->toArray();
        $dateSheet = $this->attendanceDateSheet($request);
        $studentList = $this->studentList($request, $program);
        $all_attendance = $this->attendance(
            $request,
            $program,
            array_keys(Arr::keyBy($studentList, 'user_id')),
            array_keys(Arr::keyBy($dateSheet, 'attendance_id'))
        );
        return view('admin.programs.attendance.list', compact("program", "all_attendance", 'studentList', 'dateSheet', 'sections'));
    }

    public function attendanceDateSheet(Request $request)
    {
        $carbonToday = Carbon::now();
        $start_date = $carbonToday->subDays(7)->format('Y-m-d');
        $end_date = $carbonToday->today()->format("Y-m-d");

        if (!empty($request->get('filter_dates'))) {

            $split_dates  =  explode(' - ', $request->get('filter_dates'));
            $parseStartDate = Carbon::parse($split_dates[0]);

            $parseEndDate = Carbon::parse($split_dates[1]);
            $start_date = $parseStartDate->subDay()->format("Y-m-d");
            $end_date = $parseEndDate->addDay()->format('Y-m-d');
        }

        $query = <<<SQL
            SELECT `attendance_date`, `id` AS `attendance_id`
            FROM `attendance_date_sheets` WHERE `attendance_date`
            BETWEEN ? AND ? ORDER BY `attendance_date_sheets`.`id` ASC
        SQL;

        return DB::select($query, [$start_date, $end_date]);
    }

    public function studentList(Request $request, Program $program)
    {
        $sql = "
            SELECT `members`.`full_name`, `program_students`.`student_id` AS `user_id`,
             `members`.`phone_number`,`members`.`email`,
             `program_students`.`program_id` AS `pro_id`,
             `program_sections`.`section_name` FROM
             `program_students` INNER JOIN `members`
                ON `members`.`id` = `program_students`.`student_id`
            INNER JOIN `program_sections` on `program_sections`.`id` = `program_students`.`program_section_id`
        ";
        if ($request->get('filter_member') && $request->get('filter_member') == 'paid') {
            $sql .= " INNER JOIN
            `program_student_fee_details` on `program_student_fee_details`.`student_id` = `program_students`.`student_id`
            WHERE `program_student_fee_details`.`amount_category` = 'admission_fee'
            AND `program_student_fee_details`.`verified` = 1 AND `program_student_fee_details`.`deleted_at` is NULL";

            $sql .= " AND `program_students`.`program_id` = {$program->getKey()} ";
        } else {
            $sql .= " WHERE `program_students`.`program_id` = {$program->getKey()} ";
        }


        if ($request->get('filter_section')) {
            $sql .= " AND `program_students`.`program_section_id` = {$request->get('filter_section')}";
        }



        $sql .= " AND ( `program_students`.`deleted_at` is null AND `members`.`deleted_at` is null";
        $sql .= " AND `program_sections`.`deleted_at` is null";
        $sql .= ")";
        $sql .= ' GROUP BY `members`.`id`';
        $sql = <<<SQL
            $sql
        SQL;

        $studentResult = DB::select($sql);

        return $studentResult;
    }

    public function attendance(Request $request, Program $program, array $studentID = [], array $dateId = [])
    {
        $dateIDs = implode(',', $dateId);
        $sqlQuery = "SELECT * FROM `program_student_attendances`
                    WHERE `program_student_attendances`.`program_id` = {$program->getKey()}
                    AND `attendance_date_id` in ({$dateIDs})";

        if ($request->get('filter_section')) {
            $sqlQuery .= " AND `program_student_attendances`.`section_id` = {$request->get('filter_section')}";
        }

        $sqlQuery .= "  AND `program_student_attendances`.`deleted_at` is null";
        $sql = <<<SQL
        {$sqlQuery}
        SQL;
        return DB::select($sql);
        // $attendanceList = ProgramStudentAttendance::where('program_id', $program->getKey());
        // if ($request->get('filter_section')) {
        //     $attendanceList->where('section_id', $request->get('filter_section'));
        // }

        // $attendanceList->whereIn('attendance_date_id', $dateId);
        // // $attendanceList->whereIn('student', $studentID);

        // return $attendanceList->get();
    }
}
