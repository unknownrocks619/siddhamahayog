<?php

use App\Models\AttendanceDateSheet;
use App\Models\ProgramStudentAttendance;
use Carbon\CarbonPeriod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('attendance_date_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('attendance_date');
            $table->timestamps();
        });

        $period = CarbonPeriod::create('2022-01-02', '2025-12-31');
        // Iterate over the period
        $bulkInsert = [];
        foreach ($period as $date) {
            $innerArray = [];
            $innerArray['attendance_date'] = $date->format('Y-m-d');
            $bulkInsert[] = $innerArray;
        }
        AttendanceDateSheet::insert($bulkInsert);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_date_sheets');
    }
};
