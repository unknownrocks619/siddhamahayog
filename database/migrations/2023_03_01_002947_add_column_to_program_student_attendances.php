<?php

use App\Models\AttendanceDateSheet;
use App\Models\ProgramStudentAttendance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_student_attendances', function (Blueprint $table) {
            //
            $table->integer('attendance_date_id')->after('meeting_id')->nullable()->index();
        });
        $allDataSheet = AttendanceDateSheet::get();
        $allAttendance = ProgramStudentAttendance::get();

        foreach ($allAttendance->chunk(1000) as $chunked) {
            foreach ($chunked as $attendance) {
                $formatDate = Carbon::parse($attendance->created_at)->format('Y-m-d');
                $attendanceId = $allDataSheet->where('attendance_date', $formatDate)->first();
                if ($attendanceId) {
                    $attendance->attendance_date_id = $attendanceId->getKey();
                    $attendance->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_student_attendances', function (Blueprint $table) {
            //
        });
    }
};
