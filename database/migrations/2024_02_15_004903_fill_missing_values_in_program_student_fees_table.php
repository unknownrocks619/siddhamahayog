<?php

use App\Models\ProgramStudent;
use App\Models\ProgramStudentFee;
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
       $studentFees = ProgramStudentFee::with(['member' => function($query) {
            $query->with('countries');
       }])->get();

       foreach ($studentFees as $studentFee) {

            // get current batch and student id.
            $programStudent = ProgramStudent::where('student_id',$studentFee->student_id)
                                                ->where('program_id',$studentFee->program_id)
                                                ->first();
            $full_address = $studentFee->member?->countries?->name;

            if ($studentFee->member?->city) {
                $full_address .= ", " .$studentFee->member->city;
            }

            if ($studentFee->member?->address) {
                $full_address .= ", ". $studentFee->member->address?->street_address;
            }

            $studentFee->full_name = $studentFee->member?->full_name;
            $studentFee->full_address = $full_address;
            $studentFee->phone_number = $studentFee->member?->phone_number;
            
            if ($programStudent) {
                $studentFee->program_student_id = $programStudent->getKey();
                $studentFee->student_batch_id = $programStudent->batch_id;
            }

            $studentFee->save();

       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_student_fees', function (Blueprint $table) {
            //
        });
    }
};
